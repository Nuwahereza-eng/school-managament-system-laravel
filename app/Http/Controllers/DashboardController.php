<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class DashboardController extends Controller
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
     * Display the dashboard with statistics.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Get counts for dashboard cards
        $statistics = [
            'total_students' => Student::count(),
            'active_students' => Student::where('status', 'active')->count(),
            'total_teachers' => Teacher::count(),
            'active_teachers' => Teacher::where('status', 'active')->count(),
            'total_classrooms' => Classroom::count(),
            'active_classrooms' => Classroom::where('status', 'active')->count(),
            'total_subjects' => Subject::count(),
            'active_subjects' => Subject::where('status', 'active')->count(),
        ];

        // Get student status distribution
        $studentStatusData = Student::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Get teacher status distribution
        $teacherStatusData = Teacher::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Get students per classroom
        $studentsPerClassroom = Classroom::withCount(['students' => function ($query) {
            $query->where('status', 'active');
        }])->get()->pluck('students_count', 'name')->toArray();

        // Get recent students (last 5)
        $recentStudents = Student::with('classroom')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get recent teachers (last 5)
        $recentTeachers = Teacher::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Gender distribution for students
        $studentGenderData = [
            'male' => Student::where('gender', 1)->count(),
            'female' => Student::where('gender', 0)->count(),
        ];

        // Gender distribution for teachers
        $teacherGenderData = [
            'male' => Teacher::where('gender', 1)->count(),
            'female' => Teacher::where('gender', 0)->count(),
        ];

        return view('dashboard', compact(
            'statistics',
            'studentStatusData',
            'teacherStatusData',
            'studentsPerClassroom',
            'recentStudents',
            'recentTeachers',
            'studentGenderData',
            'teacherGenderData'
        ));
    }
}
