@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <!-- Page Header -->
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="font-weight-bold mb-0">Dashboard</h4>
                            <p class="text-muted mb-0">Welcome back, {{ auth()->user()->name }}!</p>
                        </div>
                        <div>
                            <span class="text-muted">{{ now()->format('l, F j, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card bg-primary-blue text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="card-title text-white">Total Students</p>
                                    <h3 class="mb-0">{{ $statistics['total_students'] }}</h3>
                                    <small>{{ $statistics['active_students'] }} Active</small>
                                </div>
                                <i class="ti-user icon-lg"></i>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="/student" class="text-white">View All <i class="ti-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card bg-water-blue text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="card-title text-white">Total Teachers</p>
                                    <h3 class="mb-0">{{ $statistics['total_teachers'] }}</h3>
                                    <small>{{ $statistics['active_teachers'] }} Active</small>
                                </div>
                                <i class="ti-briefcase icon-lg"></i>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="/teacher" class="text-white">View All <i class="ti-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card bg-slate text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="card-title text-white">Total Classrooms</p>
                                    <h3 class="mb-0">{{ $statistics['total_classrooms'] }}</h3>
                                    <small>{{ $statistics['active_classrooms'] }} Active</small>
                                </div>
                                <i class="ti-menu-alt icon-lg"></i>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="/classroom" class="text-white">View All <i class="ti-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card bg-primary-blue text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="card-title text-white">Total Subjects</p>
                                    <h3 class="mb-0">{{ $statistics['total_subjects'] }}</h3>
                                    <small>{{ $statistics['active_subjects'] }} Active</small>
                                </div>
                                <i class="ti-book icon-lg"></i>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="/subject" class="text-white">View All <i class="ti-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Quick Actions</h4>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="/student/create" class="btn btn-primary btn-sm">
                                    <i class="ti-plus"></i> Add Student
                                </a>
                                <a href="/teacher/create" class="btn btn-water-blue btn-sm">
                                    <i class="ti-plus"></i> Add Teacher
                                </a>
                                <a href="/classroom/create" class="btn btn-primary btn-sm">
                                    <i class="ti-plus"></i> Add Classroom
                                </a>
                                <a href="/subject/create" class="btn btn-water-blue btn-sm">
                                    <i class="ti-plus"></i> Add Subject
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row">
                <!-- Students per Classroom Chart -->
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Students per Classroom</h4>
                            <canvas id="studentsPerClassroomChart" height="250"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Gender Distribution Chart -->
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Student Gender Distribution</h4>
                            <canvas id="genderChart" height="250"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Data Tables -->
            <div class="row">
                <!-- Recent Students -->
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="card-title mb-0">Recent Students</h4>
                                <a href="/student" class="btn btn-sm btn-outline-water-blue">View All</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Student #</th>
                                            <th>Classroom</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentStudents as $student)
                                            <tr>
                                                <td>{{ $student->first_name }} {{ $student->surname }}</td>
                                                <td>{{ $student->student_num }}</td>
                                                <td>{{ $student->classroom->name ?? 'N/A' }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $student->status === 'active' ? 'primary-blue' : 'slate' }}">
                                                        {{ ucfirst($student->status ?? 'active') }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">No students found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Teachers -->
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="card-title mb-0">Recent Teachers</h4>
                                <a href="/teacher" class="btn btn-sm btn-outline-water-blue">View All</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Teacher #</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentTeachers as $teacher)
                                            <tr>
                                                <td>{{ $teacher->first_name }} {{ $teacher->surname }}</td>
                                                <td>{{ $teacher->teacher_num }}</td>
                                                <td>{{ $teacher->email }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $teacher->status === 'active' ? 'water-blue' : 'slate' }}">
                                                        {{ ucfirst(str_replace('_', ' ', $teacher->status ?? 'active')) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">No teachers found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Overview -->
            <div class="row">
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Student Status Overview</h4>
                            <div class="row">
                                @foreach($studentStatusData as $status => $count)
                                    <div class="col-6 mb-3">
                                        <div class="d-flex justify-content-between">
                                            <span class="text-capitalize">{{ str_replace('_', ' ', $status) }}</span>
                                            <span class="font-weight-bold">{{ $count }}</span>
                                        </div>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar progress-bar-primary-blue" 
                                                 style="width: {{ $statistics['total_students'] > 0 ? ($count / $statistics['total_students'] * 100) : 0 }}%">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Teacher Status Overview</h4>
                            <div class="row">
                                @foreach($teacherStatusData as $status => $count)
                                    <div class="col-6 mb-3">
                                        <div class="d-flex justify-content-between">
                                            <span class="text-capitalize">{{ str_replace('_', ' ', $status) }}</span>
                                            <span class="font-weight-bold">{{ $count }}</span>
                                        </div>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar progress-bar-water-blue" 
                                                 style="width: {{ $statistics['total_teachers'] > 0 ? ($count / $statistics['total_teachers'] * 100) : 0 }}%">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>

    <!-- Chart.js Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Color palette
        const primaryBlue = '#248afd';
        const waterBlue = '#17a2b8';
        const slate = '#5a5c69';

        // Students per Classroom Chart
        const classroomData = @json($studentsPerClassroom);
        const classroomLabels = Object.keys(classroomData);
        const classroomValues = Object.values(classroomData);

        if (classroomLabels.length > 0) {
            new Chart(document.getElementById('studentsPerClassroomChart'), {
                type: 'bar',
                data: {
                    labels: classroomLabels,
                    datasets: [{
                        label: 'Number of Students',
                        data: classroomValues,
                        backgroundColor: primaryBlue,
                        borderColor: primaryBlue,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }

        // Gender Distribution Chart
        const genderData = @json($studentGenderData);
        new Chart(document.getElementById('genderChart'), {
            type: 'doughnut',
            data: {
                labels: ['Male', 'Female'],
                datasets: [{
                    data: [genderData.male, genderData.female],
                    backgroundColor: [primaryBlue, waterBlue],
                    borderColor: ['#fff', '#fff'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
@endsection
