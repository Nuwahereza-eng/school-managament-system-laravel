@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="card-title mb-0">Teachers Management</h4>
                                <a href="/teacher/create" class="btn btn-water-blue btn-sm">
                                    <i class="ti-plus"></i> Add New Teacher
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
                            <form action="/teacher" method="GET" class="mb-4">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <input type="text" name="search" class="form-control" 
                                               placeholder="Search by name, email or teacher number..." 
                                               value="{{ request('search') }}">
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
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-search">
                                            <i class="ti-search"></i> Search
                                        </button>
                                        <a href="/teacher" class="btn btn-reset">
                                            <i class="ti-reload"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </form>

                            <!-- Results Summary -->
                            <div class="mb-3">
                                <small class="text-muted">
                                    Showing {{ $teachers->firstItem() ?? 0 }} - {{ $teachers->lastItem() ?? 0 }} 
                                    of {{ $teachers->total() }} teachers
                                </small>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th style="width: 60px;">Photo</th>
                                        <th>
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'teacher_num', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="text-dark">
                                                Teacher #
                                            </a>
                                        </th>
                                        <th>
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'first_name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="text-dark">
                                                Name
                                            </a>
                                        </th>
                                        <th>Specialization</th>
                                        <th>Subjects</th>
                                        <th>Contact</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($teachers as $teacher)
                                        <tr>
                                            <td class="py-1">
                                                @if($teacher->photo_path)
                                                    <img src="{{ url('/images/'.$teacher->photo_path) }}" alt="Photo" 
                                                         class="rounded-circle" style="width: 45px; height: 45px; object-fit: cover;">
                                                @else
                                                    <div class="avatar-sm bg-{{ $teacher->gender ? 'primary-blue' : 'water-blue' }} rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                                        <span class="text-white">{{ strtoupper(substr($teacher->first_name, 0, 1)) }}</span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ $teacher->teacher_num }}</td>
                                            <td>
                                                <strong>{{ $teacher->first_name }} {{ $teacher->surname }}</strong>
                                                <br><small class="text-muted">{{ $teacher->email }}</small>
                                            </td>
                                            <td>{{ $teacher->specialization ?? 'Not specified' }}</td>
                                            <td style="white-space: normal; max-width: 200px;">
                                                @if($teacher->subjects->count() > 0)
                                                    @foreach($teacher->subjects->take(3) as $subject)
                                                        <span class="badge badge-water-blue badge-sm mb-1">{{ $subject->name }}</span>
                                                    @endforeach
                                                    @if($teacher->subjects->count() > 3)
                                                        <span class="badge badge-slate">+{{ $teacher->subjects->count() - 3 }} more</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted">No subjects</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="tel:{{ $teacher->phone_number }}">
                                                    <i class="ti-mobile"></i> {{ $teacher->phone_number }}
                                                </a>
                                            </td>
                                            <td>
                                                @php
                                                    $statusColors = [
                                                        'active' => 'water-blue',
                                                        'inactive' => 'slate',
                                                        'on_leave' => 'primary-blue',
                                                        'terminated' => 'slate',
                                                    ];
                                                @endphp
                                                <span class="badge badge-{{ $statusColors[$teacher->status] ?? 'slate' }}">
                                                    {{ ucfirst(str_replace('_', ' ', $teacher->status ?? 'active')) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="/teacher/show/{{ $teacher->id }}" class="action-btn action-btn-view" title="View">
                                                    <i class="ti-eye"></i>
                                                </a>
                                                <a href="/teacher/edit/{{ $teacher->id }}" class="action-btn action-btn-edit" title="Edit">
                                                    <i class="ti-pencil-alt"></i>
                                                </a>
                                                <form action="/teacher/delete/{{ $teacher->id }}" method="post" class="d-inline">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button onclick="return confirm('Are you sure you want to delete this teacher?')" 
                                                            type="submit" class="action-btn action-btn-delete" title="Delete">
                                                        <i class="ti-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4">
                                                <i class="ti-briefcase icon-lg text-muted"></i>
                                                <p class="text-muted mt-2">No teachers found</p>
                                                <a href="/teacher/create" class="btn btn-water-blue btn-sm">Add First Teacher</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center mt-4">
                                {!! $teachers->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
@endsection
