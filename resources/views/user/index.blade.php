@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="card-title mb-0">Managers</h4>
                                <a href="/manager/create" class="btn btn-primary btn-sm">
                                    <i class="ti-plus"></i> Add New Manager
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
                                        <th style="width: 60px;">Photo</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($managers as $manager)
                                        <tr>
                                            <td class="py-1">
                                                @if($manager->photo_path)
                                                    <img src="{{url('/images/'.$manager->photo_path)}}" alt="image" 
                                                         class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;"/>
                                                @else
                                                    <div class="avatar-sm bg-primary-blue rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                        <span class="text-white">{{ strtoupper(substr($manager->name, 0, 1)) }}</span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <strong>{{$manager->name}}</strong>
                                            </td>
                                            <td>
                                                {{$manager->email}}
                                            </td>
                                            <td>
                                                <form action="/manager/delete/{{ $manager->id }}" method="post" class="d-inline">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button onclick="return confirm('Are you sure you want to delete this manager?')" 
                                                            type="submit" class="action-btn action-btn-delete" title="Delete">
                                                        <i class="ti-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4">
                                                <i class="ti-user icon-lg text-muted"></i>
                                                <p class="text-muted mt-2">No managers found</p>
                                                <a href="/manager/create" class="btn btn-primary btn-sm">Add First Manager</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center mt-4">
                                {!! $managers->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>

@endsection
