@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="card-title mb-0">Subjects Management</h4>
                                <a href="/subject/create" class="btn btn-water-blue btn-sm">
                                    <i class="ti-plus"></i> Add New Subject
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

                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>Subject Code</th>
                                        <th>Subject Name</th>
                                        <th>Classroom</th>
                                        <th>Teacher</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($subjects as $subject)
                                        <tr>
                                            <td class="py-1">
                                                <span class="badge badge-slate">{{$subject->subject_code}}</span>
                                            </td>
                                            <td>
                                                <strong>{{$subject->name}}</strong>
                                            </td>
                                            <td>
                                                <span class="badge badge-primary-blue">{{$subject->classroom->name}}</span>
                                            </td>
                                            <td>
                                                @if(isset($subject->teacher))
                                                    <span class="badge badge-water-blue">{{$subject->teacher->first_name}} {{$subject->teacher->surname}}</span>
                                                @else
                                                    <span class="text-muted">Unassigned</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="/subject/edit/{{ $subject->id }}" class="action-btn action-btn-edit" title="Edit">
                                                    <i class="ti-pencil-alt"></i>
                                                </a>
                                                <form action="/subject/delete/{{ $subject->id }}" method="post" class="d-inline">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button onclick="return confirm('Are you sure you want to delete this subject?')" 
                                                            type="submit" class="action-btn action-btn-delete" title="Delete">
                                                        <i class="ti-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <i class="ti-book icon-lg text-muted"></i>
                                                <p class="text-muted mt-2">No subjects found</p>
                                                <a href="/subject/create" class="btn btn-water-blue btn-sm">Add First Subject</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center mt-4">
                                {!! $subjects->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>

@endsection
