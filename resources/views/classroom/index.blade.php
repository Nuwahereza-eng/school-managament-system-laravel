@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="card-title mb-0">Classrooms Management</h4>
                                <a href="/classroom/create" class="btn btn-primary btn-sm">
                                    <i class="ti-plus"></i> Add New Classroom
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
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Students Count</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($classrooms as $classroom)
                                    <tr>
                                        <td class="py-1">
                                            {{$classroom->id}}
                                        </td>
                                        <td>
                                            <strong>{{$classroom->name}}</strong>
                                        </td>
                                        <td>
                                            {{$classroom->description}}
                                        </td>
                                        <td style="text-align: center">
                                            <span class="badge badge-water-blue">{{$classroom->students->count()}}</span>
                                        </td>
                                        <td>
                                            <a href="/classroom/edit/{{ $classroom->id }}" class="action-btn action-btn-edit" title="Edit">
                                                <i class="ti-pencil-alt"></i>
                                            </a>
                                            <form action="/classroom/delete/{{ $classroom->id }}" method="post" class="d-inline">
                                                @method('DELETE')
                                                @csrf
                                                <button onclick="return confirm('Are you sure you want to delete this classroom?')" 
                                                        type="submit" class="action-btn action-btn-delete" title="Delete">
                                                    <i class="ti-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <i class="ti-menu-alt icon-lg text-muted"></i>
                                                <p class="text-muted mt-2">No classrooms found</p>
                                                <a href="/classroom/create" class="btn btn-primary btn-sm">Add First Classroom</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center mt-4">
                                {!! $classrooms->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>

@endsection
