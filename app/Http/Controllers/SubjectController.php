<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectAddUpdateRequest;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SubjectController extends Controller
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
     * Display a listing of the resource with search and filter.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Subject::with(['classroom', 'teacher']);

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by classroom
        if ($request->filled('classroom_id')) {
            $query->inClassroom($request->classroom_id);
        }

        // Filter by teacher
        if ($request->filled('teacher_id')) {
            $query->byTeacher($request->teacher_id);
        }

        // Filter by semester
        if ($request->filled('semester')) {
            $query->inSemester($request->semester);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sort functionality
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $allowedSortFields = ['name', 'subject_code', 'semester', 'created_at'];
        
        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection);
        }

        $subjects = $query->paginate(10)->appends($request->query());
        $classrooms = Classroom::active()->get();
        $teachers = Teacher::active()->get();
        $statusOptions = Subject::getStatusOptions();
        $semesterOptions = Subject::getSemesterOptions();

        return view('subject.index', compact('subjects', 'classrooms', 'teachers', 'statusOptions', 'semesterOptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $classrooms = Classroom::active()->get();
        $teachers = Teacher::active()->get();
        $statusOptions = Subject::getStatusOptions();
        $semesterOptions = Subject::getSemesterOptions();
        return view('subject.view', compact('classrooms', 'teachers', 'statusOptions', 'semesterOptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SubjectAddUpdateRequest $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(SubjectAddUpdateRequest $request)
    {
        try {
            DB::transaction(function () use ($request){
                Subject::create([
                    'subject_code' => $this->generateSubjectNumber(),
                    'name' => $request->get('name'),
                    'semester' => $request->get('semester'),
                    'description' => $request->get('description'),
                    'teacher_id' => $request->get('teacher'),
                    'classroom_id' => $request->get('classroom'),
                    'credits' => $request->get('credits', 3),
                    'status' => $request->get('status', 'active'),
                ]);
            });
        } catch (\Exception $exception){
            // Back to form with errors
            return redirect('/subject/create')
                ->withErrors($exception->getMessage())
                ->withInput();
        }
        return redirect('/subject')->with('success', 'A New Subject Added Successfully.');
    }

    /**
     * Display the specified subject.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(int $id)
    {
        $subject = Subject::with(['classroom.students', 'teacher'])->findOrFail($id);
        return view('subject.show', compact('subject'));
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
        $teachers = Teacher::active()->get();
        $subject = Subject::findOrFail($id);
        $statusOptions = Subject::getStatusOptions();
        $semesterOptions = Subject::getSemesterOptions();
        return view('subject.view', compact('teachers', 'classrooms', 'subject', 'statusOptions', 'semesterOptions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SubjectAddUpdateRequest $request
     * @param int $id
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function update(SubjectAddUpdateRequest $request, int $id)
    {
        $subject = Subject::findOrFail($id);
        try {
            DB::transaction(function () use ($request, $subject){
                $subject->name = $request->get('name');
                $subject->semester = $request->get('semester');
                $subject->description = $request->get('description');
                $subject->teacher_id = $request->get('teacher');
                $subject->classroom_id = $request->get('classroom');
                $subject->credits = $request->get('credits', $subject->credits);
                $subject->status = $request->get('status', $subject->status);
                $subject->save();
            });
        } catch (\Exception $exception){
            // Back to form with errors
            return redirect('/subject/edit/'.$id)
                ->withErrors($exception->getMessage())->withInput();
        }
        return redirect('/subject')->with('success', 'Subject Updated Successfully.');
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
            Subject::destroy($id);
        } catch (\Exception $exception){
            return redirect('/subject')->withErrors($exception->getMessage());
        }
        return redirect('/subject')->with('success', 'Subject deleted successfully.');
    }

    /**
     * Generate a unique subject code.
     *
     * @return string
     */
    public function generateSubjectNumber(): string
    {
        return (string)str('SC-')->append($this->getLastSubjectId());
    }

    /**
     * Get the last subject ID for code generation.
     *
     * @return string
     */
    private function getLastSubjectId(): string
    {
        $last = Subject::query()->orderByDesc('subject_code')->first('subject_code');
        if($last != null){
            $lastNum = (string)Str::of($last)->after('-');
            return sprintf("%06d", (int)$lastNum + 1);
        } else {
            return sprintf("%06d", 1);
        }
    }
}
