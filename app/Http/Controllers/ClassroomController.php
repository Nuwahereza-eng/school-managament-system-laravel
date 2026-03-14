<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassroomAddUpdateRequest;
use App\Models\Classroom;
use App\Models\Student;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ClassroomController extends Controller
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
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Classroom::withCount(['students', 'subjects']);

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sort functionality
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $allowedSortFields = ['name', 'capacity', 'created_at'];
        
        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection);
        }

        $classrooms = $query->paginate(10)->appends($request->query());
        $statusOptions = Classroom::getStatusOptions();

        return view('classroom.index', compact('classrooms', 'statusOptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $statusOptions = Classroom::getStatusOptions();
        return view('classroom.view', compact('statusOptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ClassroomAddUpdateRequest $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(ClassroomAddUpdateRequest $request)
    {
        try {
            Classroom::create([
                'name' => $request->name,
                'description' => $request->description,
                'capacity' => $request->capacity ?? 30,
                'status' => $request->status ?? 'active',
            ]);
        } catch (\Exception $exception) {
            return redirect('/classroom/create')
                ->withErrors($exception->getMessage())
                ->withInput();
        }
        return redirect('/classroom')->with('success', 'A New Classroom Added Successfully.');
    }

    /**
     * Display the specified classroom.
     *
     * @param  int  $id
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(int $id)
    {
        $classroom = Classroom::with(['students', 'subjects.teacher', 'teachers'])->findOrFail($id);
        return view('classroom.show', compact('classroom'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $classroom = Classroom::findOrFail($id);
        $statusOptions = Classroom::getStatusOptions();
        return view('classroom.view', compact('classroom', 'statusOptions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ClassroomAddUpdateRequest $request
     * @param int $id
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function update(ClassroomAddUpdateRequest $request, int $id)
    {
        try {
            $classroom = Classroom::findOrFail($id);
            $classroom->update([
                'name' => $request->name,
                'description' => $request->description,
                'capacity' => $request->capacity ?? $classroom->capacity,
                'status' => $request->status ?? $classroom->status,
            ]);
        } catch (\Exception $exception) {
            return redirect('/classroom/edit/'.$id)
                ->withErrors($exception->getMessage())
                ->withInput();
        }
        return redirect('/classroom')->with('success', 'Classroom Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function destroy(int $id)
    {
        try {
            $classroom = Classroom::findOrFail($id);
            // Check if classroom has students
            if ($classroom->students()->count() > 0) {
                return redirect('/classroom')->withErrors('Cannot delete classroom with enrolled students.');
            }
            $classroom->delete();
        } catch (\Exception $exception) {
            return redirect('/classroom')->withErrors($exception->getMessage());
        }
        return redirect('/classroom')->with('success', 'Classroom deleted successfully.');
    }
}
