<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentAddUpdateRequest;
use App\Models\Classroom;
use App\Models\Student;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource with search and filter capabilities.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Student::with('classroom');

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by classroom
        if ($request->filled('classroom_id')) {
            $query->inClassroom($request->classroom_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->withStatus($request->status);
        }

        // Filter by gender
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // Sort functionality
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $allowedSortFields = ['first_name', 'surname', 'student_num', 'enrollment_date', 'created_at'];
        
        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection);
        }

        $students = $query->paginate(10)->appends($request->query());
        $classrooms = Classroom::active()->get();
        $statusOptions = Student::getStatusOptions();

        return view('student.index', compact('students', 'classrooms', 'statusOptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $classrooms = Classroom::active()->get();
        $statusOptions = Student::getStatusOptions();
        return view('student.view', compact('classrooms', 'statusOptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StudentAddUpdateRequest $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(StudentAddUpdateRequest $request)
    {
        try {
            // Safely perform set of DB related queries if fail rollback all.
            DB::transaction(function () use ($request){
                Student::create([
                    'student_num' => $this->generateStudentNumber(),
                    'first_name' => $request->get('first_name'),
                    'surname' => $request->get('surname'),
                    'birth_date' => $request->get('birth_date'),
                    'classroom_id' => $request->get('classroom'),
                    'parent_phone_number' => $request->get('parent_phone_number'),
                    'second_phone_number' => $request->get('second_phone_number'),
                    'enrollment_date' => $request->get('enrollment_date'),
                    'address' => $request->get('address'),
                    'gender' => $request->get('gender'),
                    'status' => $request->get('status', 'active'),
                    'notes' => $request->get('notes'),
                ]);
            });
        } catch (\Exception $exception){
            // Back to form with errors
            return redirect('/student/create')
                ->withErrors($exception->getMessage())
                ->withInput();
        }
        return redirect('/student')->with('success', 'A New Student Added Successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $classrooms = Classroom::active()->get();
        $student = Student::findOrFail($id);
        $statusOptions = Student::getStatusOptions();
        return view('student.view', compact('student', 'classrooms', 'statusOptions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StudentAddUpdateRequest $request
     * @param int $id
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function update(StudentAddUpdateRequest $request, int $id)
    {
        $student = Student::findOrFail($id);
        try {
            // Safely perform set of DB related queries if fail rollback all.
            DB::transaction(function () use ($request, $student){
                $student->first_name = $request->first_name;
                $student->surname = $request->surname;
                $student->birth_date = $request->birth_date;
                $student->classroom_id = $request->classroom;
                $student->parent_phone_number = $request->parent_phone_number;
                $student->second_phone_number = $request->second_phone_number;
                $student->address = $request->address;
                $student->enrollment_date = $request->enrollment_date;
                $student->gender = $request->gender;
                $student->status = $request->status ?? $student->status;
                $student->notes = $request->notes;
                $student->save();
            });
        } catch (\Exception $exception){
            // Back to form with errors
            return redirect('/student/edit/'.$id)
                ->withErrors($exception->getMessage())
                ->withInput();
        }
        return redirect('/student')->with('success', 'Student Updated Successfully.');
    }

    /**
     * Display the specified student details.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(int $id)
    {
        $student = Student::with(['classroom', 'subjects.teacher'])->findOrFail($id);
        return view('student.show', compact('student'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function destroy(int $id)
    {
        try {
            Student::destroy($id);
        } catch (\Exception $exception){
            return redirect('/student')->withErrors($exception->getMessage());
        }
        return redirect('/student')->with('success', 'Student deleted successfully.');
    }

    /**
     * Generate a unique student number.
     *
     * @return string
     */
    public function generateStudentNumber(): string
    {
        return (string)str('STDN-')->append($this->getLastStudentId());
    }

    /**
     * Get the last student ID for number generation.
     *
     * @return string
     */
    private function getLastStudentId(): string
    {
        $last = Student::query()->orderByDesc('student_num')->first('student_num');
        if($last != null){
            $lastNum = (string)Str::of($last)->after('-');
            return sprintf("%06d", (int)$lastNum + 1);
        } else {
            return sprintf("%06d", 1);
        }
    }
}
