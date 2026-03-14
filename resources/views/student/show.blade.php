@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="font-weight-bold mb-0">Student Details</h4>
                        <div>
                            <a href="/student/edit/{{ $student->id }}" class="btn btn-primary btn-sm">
                                <i class="ti-pencil"></i> Edit
                            </a>
                            <a href="/student" class="btn btn-secondary btn-sm">
                                <i class="ti-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Student Information Card -->
                <div class="col-lg-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="avatar-lg bg-{{ $student->gender ? 'primary-blue' : 'water-blue' }} rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                <span class="text-white" style="font-size: 2.5rem;">{{ strtoupper(substr($student->first_name, 0, 1)) }}{{ strtoupper(substr($student->surname, 0, 1)) }}</span>
                            </div>
                            <h4 class="card-title">{{ $student->first_name }} {{ $student->surname }}</h4>
                            <p class="text-muted">{{ $student->student_num }}</p>
                            @php
                                $statusColors = [
                                    'active' => 'primary-blue',
                                    'inactive' => 'slate',
                                    'graduated' => 'water-blue',
                                    'transferred' => 'slate',
                                    'suspended' => 'slate',
                                ];
                            @endphp
                            <span class="badge badge-{{ $statusColors[$student->status] ?? 'slate' }} badge-lg">
                                {{ ucfirst($student->status ?? 'active') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="col-lg-8 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Personal Information</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted">First Name</label>
                                    <p class="font-weight-bold">{{ $student->first_name }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted">Surname</label>
                                    <p class="font-weight-bold">{{ $student->surname }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted">Date of Birth</label>
                                    <p class="font-weight-bold">{{ \Carbon\Carbon::parse($student->birth_date)->format('F j, Y') }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted">Gender</label>
                                    <p class="font-weight-bold">{{ $student->gender ? 'Male' : 'Female' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted">Enrollment Date</label>
                                    <p class="font-weight-bold">{{ \Carbon\Carbon::parse($student->enrollment_date)->format('F j, Y') }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted">Classroom</label>
                                    <p class="font-weight-bold">
                                        <a href="/classroom/show/{{ $student->classroom->id ?? '' }}">
                                            {{ $student->classroom->name ?? 'N/A' }}
                                        </a>
                                    </p>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="text-muted">Address</label>
                                    <p class="font-weight-bold">{{ $student->address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Contact Information -->
                <div class="col-lg-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Contact Information</h5>
                            <div class="mb-3">
                                <label class="text-muted">Parent Phone Number</label>
                                <p class="font-weight-bold">
                                    <a href="tel:{{ $student->parent_phone_number }}">
                                        <i class="ti-mobile"></i> {{ $student->parent_phone_number }}
                                    </a>
                                </p>
                            </div>
                            @if($student->second_phone_number)
                                <div class="mb-3">
                                    <label class="text-muted">Secondary Phone Number</label>
                                    <p class="font-weight-bold">
                                        <a href="tel:{{ $student->second_phone_number }}">
                                            <i class="ti-mobile"></i> {{ $student->second_phone_number }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="col-lg-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Notes</h5>
                            <p>{{ $student->notes ?? 'No notes available.' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subjects -->
            @if($student->subjects && $student->subjects->count() > 0)
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Enrolled Subjects</h5>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Subject Code</th>
                                                <th>Subject Name</th>
                                                <th>Teacher</th>
                                                <th>Semester</th>
                                                <th>Credits</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($student->subjects as $subject)
                                                <tr>
                                                    <td>{{ $subject->subject_code }}</td>
                                                    <td>{{ $subject->name }}</td>
                                                    <td>
                                                        @if($subject->teacher)
                                                            <a href="/teacher/show/{{ $subject->teacher->id }}">
                                                                {{ $subject->teacher->first_name }} {{ $subject->teacher->surname }}
                                                            </a>
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                    <td>Semester {{ $subject->semester }}</td>
                                                    <td>{{ $subject->credits ?? 3 }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- System Information -->
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">System Information</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="text-muted">Created At</label>
                                    <p class="font-weight-bold">{{ $student->created_at ? $student->created_at->format('F j, Y, g:i a') : 'N/A' }}</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="text-muted">Last Updated</label>
                                    <p class="font-weight-bold">{{ $student->updated_at ? $student->updated_at->format('F j, Y, g:i a') : 'N/A' }}</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="text-muted">Record ID</label>
                                    <p class="font-weight-bold">#{{ $student->id }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
@endsection
