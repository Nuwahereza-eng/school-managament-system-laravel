@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="card-title mb-0">Students Management</h4>
                                <a href="/student/create" class="btn btn-primary btn-sm">
                                    <i class="ti-plus"></i> Add New Student
                                </a>
                            </div>

                            <!-- Success/Error Messages -->
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif
                            @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <!-- Search and Filter Form -->
                            <form action="/student" method="GET" class="mb-4">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <input type="text" name="search" class="form-control" 
                                               placeholder="Search by name or student number..." 
                                               value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="classroom_id" class="form-control">
                                            <option value="">All Classrooms</option>
                                            @foreach($classrooms as $classroom)
                                                <option value="{{ $classroom->id }}" {{ request('classroom_id') == $classroom->id ? 'selected' : '' }}>
                                                    {{ $classroom->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status" class="form-control">
                                            <option value="">All Status</option>
                                            @foreach($statusOptions as $value => $label)
                                                <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="gender" class="form-control">
                                            <option value="">All Genders</option>
                                            <option value="1" {{ request('gender') === '1' ? 'selected' : '' }}>Male</option>
                                            <option value="0" {{ request('gender') === '0' ? 'selected' : '' }}>Female</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-search">
                                            <i class="ti-search"></i> Search
                                        </button>
                                        <a href="/student" class="btn btn-reset">
                                            <i class="ti-reload"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </form>

                            <!-- Results Summary -->
                            <div class="mb-3">
                                <small class="text-muted">
                                    Showing {{ $students->firstItem() ?? 0 }} - {{ $students->lastItem() ?? 0 }} 
                                    of {{ $students->total() }} students
                                </small>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'first_name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="text-dark">
                                                Name
                                                @if(request('sort') === 'first_name')
                                                    <i class="ti-arrow-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'student_num', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="text-dark">
                                                Student Number
                                            </a>
                                        </th>
                                        <th>Parent Phone</th>
                                        <th>Classroom</th>
                                        <th>Status</th>
                                        <th>
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'enrollment_date', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="text-dark">
                                                Enrollment Date
                                            </a>
                                        </th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($students as $student)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-{{ $student->gender ? 'primary-blue' : 'water-blue' }} rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                                        <span class="text-white">{{ strtoupper(substr($student->first_name, 0, 1)) }}</span>
                                                    </div>
                                                    <div>
                                                        <strong>{{ $student->first_name }} {{ $student->surname }}</strong>
                                                        <br><small class="text-muted">{{ $student->gender ? 'Male' : 'Female' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $student->student_num }}</td>
                                            <td style="white-space: normal;">
                                                <a href="tel:{{ $student->parent_phone_number }}">{{ $student->parent_phone_number }}</a>
                                                @if($student->second_phone_number)
                                                    <br><small><a href="tel:{{ $student->second_phone_number }}">{{ $student->second_phone_number }}</a></small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-water-blue">{{ $student->classroom->name ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                @php
                                                    $statusColors = [
                                                        'active' => 'primary-blue',
                                                        'inactive' => 'slate',
                                                        'graduated' => 'water-blue',
                                                        'transferred' => 'slate',
                                                        'suspended' => 'slate',
                                                    ];
                                                @endphp
                                                <span class="badge badge-{{ $statusColors[$student->status] ?? 'slate' }}">
                                                    {{ ucfirst($student->status ?? 'active') }}
                                                </span>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($student->enrollment_date)->format('M d, Y') }}</td>
                                            <td>
                                                <a href="/student/show/{{ $student->id }}" class="action-btn action-btn-view" title="View">
                                                    <i class="ti-eye"></i>
                                                </a>
                                                <a href="/student/edit/{{ $student->id }}" class="action-btn action-btn-edit" title="Edit">
                                                    <i class="ti-pencil-alt"></i>
                                                </a>
                                                <form action="/student/delete/{{ $student->id }}" method="post" class="d-inline">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button onclick="return confirm('Are you sure you want to delete this student?')" 
                                                            type="submit" class="action-btn action-btn-delete" title="Delete">
                                                        <i class="ti-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <i class="ti-user icon-lg text-muted"></i>
                                                <p class="text-muted mt-2">No students found</p>
                                                <a href="/student/create" class="btn btn-primary btn-sm">Add First Student</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center mt-4">
                                {!! $students->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
@endsection
