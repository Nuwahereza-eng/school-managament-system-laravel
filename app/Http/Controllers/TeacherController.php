<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherAddUpdateRequest;
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

class TeacherController extends Controller
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
        $query = Teacher::with('subjects');

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->withStatus($request->status);
        }

        // Filter by specialization
        if ($request->filled('specialization')) {
            $query->withSpecialization($request->specialization);
        }

        // Filter by gender
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // Sort functionality
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $allowedSortFields = ['first_name', 'surname', 'teacher_num', 'hire_date', 'created_at'];
        
        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection);
        }

        $teachers = $query->paginate(10)->appends($request->query());
        $statusOptions = Teacher::getStatusOptions();

        return view('teacher.index', compact('teachers', 'statusOptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $classrooms = Classroom::active()->get();
        $statusOptions = Teacher::getStatusOptions();
        return view('teacher.view', compact('classrooms', 'statusOptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TeacherAddUpdateRequest $request
     * @return false|Application|RedirectResponse|Response|Redirector|string
     */
    public function store(TeacherAddUpdateRequest $request)
    {
        try {
            // Safely perform set of DB related queries if fail rollback all.
            DB::transaction(function () use ($request){
                $photo_path = null;
                if ($request->hasFile('photo')) {
                    $path = Str::of('Teachers/')->append($request->get('surname'));
                    // Save the file locally in the public/images folder under a new folder named /Teachers
                    $photo = $request->file('photo');
                    $photo_path = $photo->storeAs($path, $photo->getClientOriginalName(), 'images');
                }

                Teacher::create([
                    'teacher_num' => $this->generateTeacherNumber(),
                    'first_name' => $request->get('first_name'),
                    'surname' => $request->get('surname'),
                    'birth_date' => $request->get('birth_date'),
                    'email' => $request->get('email'),
                    'phone_number' => $request->get('phone_number'),
                    'photo_path' => $photo_path,
                    'address' => $request->get('address'),
                    'gender' => $request->get('gender'),
                    'status' => $request->get('status', 'active'),
                    'hire_date' => $request->get('hire_date'),
                    'qualification' => $request->get('qualification'),
                    'specialization' => $request->get('specialization'),
                ]);
            });
        } catch (\Exception $exception){
            // Back to form with errors
            return redirect('/teacher/create')
                ->withErrors($exception->getMessage())
                ->withInput();
        }
        return redirect('/teacher')->with('success', 'A New Teacher Added Successfully.');
    }

    /**
     * Display the specified teacher details.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(int $id)
    {
        $teacher = Teacher::with(['subjects.classroom'])->findOrFail($id);
        return view('teacher.show', compact('teacher'));
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
        $teacher = Teacher::findOrFail($id);
        $statusOptions = Teacher::getStatusOptions();
        return view('teacher.view', compact('teacher', 'classrooms', 'statusOptions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TeacherAddUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(TeacherAddUpdateRequest $request, int $id)
    {
        $teacher = Teacher::findOrFail($id);
        try {
            DB::transaction(function () use ($request, $teacher){
                $photo_path = $teacher->photo_path;
                if ($request->hasFile('photo')) {
                    try {
                        // remove the image locally.
                        if ($teacher->photo_path) {
                            unlink(public_path('/images/' . $teacher->photo_path));
                        }
                    } catch (\Exception $exception) {
                        // Image doesn't exist, continue
                    }
                    $path = Str::of('Teachers/')->append($request->get('surname'));
                    // Save the file locally in the public/images folder under a new folder named /Teachers
                    $photo = $request->file('photo');
                    $photo_path = $photo->storeAs($path, $photo->getClientOriginalName(), 'images');
                }
                $teacher->first_name = $request->first_name;
                $teacher->surname = $request->surname;
                $teacher->birth_date = $request->birth_date;
                $teacher->email = $request->email;
                $teacher->phone_number = $request->phone_number;
                $teacher->photo_path = $photo_path;
                $teacher->address = $request->address;
                $teacher->gender = $request->gender;
                $teacher->status = $request->status ?? $teacher->status;
                $teacher->hire_date = $request->hire_date;
                $teacher->qualification = $request->qualification;
                $teacher->specialization = $request->specialization;
                $teacher->save();
            });
        } catch (\Exception $exception){
            // Back to form with errors
            return redirect('/teacher/edit/'.$id)
                ->withErrors($exception->getMessage())->withInput();
        }
        return redirect('/teacher')->with('success', 'Teacher Updated Successfully.');
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
            $teacher = Teacher::findOrFail($id);
            // Remove photo if exists
            if ($teacher->photo_path) {
                try {
                    unlink(public_path('/images/' . $teacher->photo_path));
                } catch (\Exception $e) {
                    // Image doesn't exist, continue
                }
            }
            $teacher->delete();
        } catch (\Exception $exception){
            return redirect('/teacher')->withErrors($exception->getMessage());
        }
        return redirect('/teacher')->with('success', 'Teacher deleted successfully.');
    }

    /**
     * Get subjects for a specific classroom (AJAX).
     *
     * @param int $id
     * @return string
     */
    public function getSubjects($id)
    {
        $subs = Subject::query()->where('classroom_id', $id)->get();
        $outputhtml = '<option value="">Select a Subject</option>';
        foreach ($subs as $sub) {
            $outputhtml .= '<option value="' . $sub->id . '">' . $sub->name . '</option>';
        }
        return $outputhtml;
    }

    /**
     * Generate a unique teacher number.
     *
     * @return string
     */
    public function generateTeacherNumber(): string
    {
        return (string)str('TN-')->append($this->getLastTeacherId());
    }

    /**
     * Get the last teacher ID for number generation.
     *
     * @return string
     */
    private function getLastTeacherId(): string
    {
        $last = Teacher::query()->orderByDesc('teacher_num')->first('teacher_num');
        if($last != null){
            $lastNum = (string)Str::of($last)->after('-');
            return sprintf("%06d", (int)$lastNum + 1);
        } else {
            return sprintf("%06d", 1);
        }
    }
}
