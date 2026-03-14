@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="font-weight-bold mb-0">Teacher Details</h4>
                        <div>
                            <a href="/teacher/edit/{{ $teacher->id }}" class="btn btn-water-blue btn-sm">
                                <i class="ti-pencil"></i> Edit
                            </a>
                            <a href="/teacher" class="btn btn-secondary btn-sm">
                                <i class="ti-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Teacher Profile Card -->
                <div class="col-lg-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body text-center">
                            @if($teacher->photo_path)
                                <img src="{{ url('/images/'.$teacher->photo_path) }}" alt="Photo" 
                                     class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <div class="avatar-lg bg-{{ $teacher->gender ? 'primary-blue' : 'water-blue' }} rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 150px; height: 150px;">
                                    <span class="text-white" style="font-size: 3rem;">{{ strtoupper(substr($teacher->first_name, 0, 1)) }}{{ strtoupper(substr($teacher->surname, 0, 1)) }}</span>
                                </div>
                            @endif
                            <h4 class="card-title">{{ $teacher->first_name }} {{ $teacher->surname }}</h4>
                            <p class="text-muted">{{ $teacher->teacher_num }}</p>
                            @php
                                $statusColors = [
                                    'active' => 'water-blue',
                                    'inactive' => 'slate',
                                    'on_leave' => 'primary-blue',
                                    'terminated' => 'slate',
                                ];
                            @endphp
                            <span class="badge badge-{{ $statusColors[$teacher->status] ?? 'slate' }} badge-lg">
                                {{ ucfirst(str_replace('_', ' ', $teacher->status ?? 'active')) }}
                            </span>
                            @if($teacher->specialization)
                                <p class="mt-3"><strong>Specialization:</strong> {{ $teacher->specialization }}</p>
                            @endif
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
                                    <p class="font-weight-bold">{{ $teacher->first_name }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted">Surname</label>
                                    <p class="font-weight-bold">{{ $teacher->surname }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted">Date of Birth</label>
                                    <p class="font-weight-bold">{{ \Carbon\Carbon::parse($teacher->birth_date)->format('F j, Y') }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted">Gender</label>
                                    <p class="font-weight-bold">{{ $teacher->gender ? 'Male' : 'Female' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted">Hire Date</label>
                                    <p class="font-weight-bold">{{ $teacher->hire_date ? \Carbon\Carbon::parse($teacher->hire_date)->format('F j, Y') : 'Not specified' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted">Qualification</label>
                                    <p class="font-weight-bold">{{ $teacher->qualification ?? 'Not specified' }}</p>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="text-muted">Address</label>
                                    <p class="font-weight-bold">{{ $teacher->address }}</p>
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
                                <label class="text-muted">Email Address</label>
                                <p class="font-weight-bold">
                                    <a href="mailto:{{ $teacher->email }}">
                                        <i class="ti-email"></i> {{ $teacher->email }}
                                    </a>
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted">Phone Number</label>
                                <p class="font-weight-bold">
                                    <a href="tel:{{ $teacher->phone_number }}">
                                        <i class="ti-mobile"></i> {{ $teacher->phone_number }}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Teaching Statistics -->
                <div class="col-lg-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Teaching Statistics</h5>
                            <div class="row">
                                <div class="col-6 text-center">
                                    <h2 class="text-primary-blue">{{ $teacher->subjects->count() }}</h2>
                                    <p class="text-muted">Subjects Teaching</p>
                                </div>
                                <div class="col-6 text-center">
                                    <h2 class="text-water-blue">{{ $teacher->classrooms->count() }}</h2>
                                    <p class="text-muted">Classrooms</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subjects Teaching -->
            @if($teacher->subjects && $teacher->subjects->count() > 0)
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Subjects Teaching</h5>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Subject Code</th>
                                                <th>Subject Name</th>
                                                <th>Classroom</th>
                                                <th>Semester</th>
                                                <th>Credits</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($teacher->subjects as $subject)
                                                <tr>
                                                    <td>{{ $subject->subject_code }}</td>
                                                    <td>{{ $subject->name }}</td>
                                                    <td>
                                                        @if($subject->classroom)
                                                            <a href="/classroom/show/{{ $subject->classroom->id }}">
                                                                {{ $subject->classroom->name }}
                                                            </a>
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                    <td>Semester {{ $subject->semester }}</td>
                                                    <td>{{ $subject->credits ?? 3 }}</td>
                                                    <td>
                                                        <span class="badge badge-{{ $subject->status === 'active' ? 'success' : 'secondary' }}">
                                                            {{ ucfirst($subject->status ?? 'active') }}
                                                        </span>
                                                    </td>
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
                                    <p class="font-weight-bold">{{ $teacher->created_at ? $teacher->created_at->format('F j, Y, g:i a') : 'N/A' }}</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="text-muted">Last Updated</label>
                                    <p class="font-weight-bold">{{ $teacher->updated_at ? $teacher->updated_at->format('F j, Y, g:i a') : 'N/A' }}</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="text-muted">Record ID</label>
                                    <p class="font-weight-bold">#{{ $teacher->id }}</p>
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
