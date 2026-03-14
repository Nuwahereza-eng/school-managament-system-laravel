@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="font-weight-bold mb-0">{{ isset($student) ? 'Edit Student' : 'Add New Student' }}</h4>
                        <a href="/student" class="btn btn-secondary btn-sm">
                            <i class="ti-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            @if(isset($student))
                                <p class="text-muted mb-4">Editing student: <strong>{{ $student->student_num }}</strong></p>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Please correct the following errors:</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form class="forms-sample" action="{{ isset($student) ? '/student/update/'.$student->id : '/student/store' }}" method="post">
                                @csrf

                                <!-- Personal Information Section -->
                                <h5 class="mb-3 text-primary"><i class="ti-user"></i> Personal Information</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                                   name="first_name" id="first_name" autofocus
                                                   placeholder="Enter first name" 
                                                   value="{{ old('first_name', $student->first_name ?? '') }}">
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="surname" class="form-label">Surname <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('surname') is-invalid @enderror" 
                                                   name="surname" id="surname"
                                                   placeholder="Enter surname" 
                                                   value="{{ old('surname', $student->surname ?? '') }}">
                                            @error('surname')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                                            <select id="gender" name="gender" class="form-control @error('gender') is-invalid @enderror">
                                                <option value="">Select Gender</option>
                                                <option value="1" {{ old('gender', $student->gender ?? '') == '1' ? 'selected' : '' }}>Male</option>
                                                <option value="0" {{ old('gender', $student->gender ?? '') === '0' || (isset($student) && $student->gender == 0) ? 'selected' : '' }}>Female</option>
                                            </select>
                                            @error('gender')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="birth_date" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                                                   name="birth_date" id="birth_date"
                                                   value="{{ old('birth_date', isset($student) ? \Carbon\Carbon::parse($student->birth_date)->format('Y-m-d') : '') }}">
                                            @error('birth_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Academic Information Section -->
                                <h5 class="mb-3 mt-4 text-primary"><i class="ti-book"></i> Academic Information</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="classroom" class="form-label">Classroom <span class="text-danger">*</span></label>
                                            <select id="classroom" name="classroom" class="form-control @error('classroom') is-invalid @enderror">
                                                <option value="">Select a Classroom</option>
                                                @foreach($classrooms as $classroom)
                                                    <option value="{{ $classroom->id }}" 
                                                            {{ old('classroom', $student->classroom_id ?? '') == $classroom->id ? 'selected' : '' }}>
                                                        {{ $classroom->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('classroom')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="enrollment_date" class="form-label">Enrollment Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control @error('enrollment_date') is-invalid @enderror" 
                                                   name="enrollment_date" id="enrollment_date"
                                                   value="{{ old('enrollment_date', isset($student) ? \Carbon\Carbon::parse($student->enrollment_date)->format('Y-m-d') : '') }}">
                                            @error('enrollment_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status" class="form-label">Status</label>
                                            <select id="status" name="status" class="form-control @error('status') is-invalid @enderror">
                                                @foreach($statusOptions as $value => $label)
                                                    <option value="{{ $value }}" 
                                                            {{ old('status', $student->status ?? 'active') == $value ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Information Section -->
                                <h5 class="mb-3 mt-4 text-primary"><i class="ti-mobile"></i> Contact Information</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="parent_phone_number" class="form-label">Parent Phone Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('parent_phone_number') is-invalid @enderror" 
                                                   name="parent_phone_number" id="parent_phone_number"
                                                   placeholder="e.g., 0771234567 or +256771234567" 
                                                   value="{{ old('parent_phone_number', $student->parent_phone_number ?? '') }}">
                                            @error('parent_phone_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Uganda format: 07XXXXXXXX or +256XXXXXXXXX</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="second_phone_number" class="form-label">Secondary Phone Number</label>
                                            <input type="text" class="form-control @error('second_phone_number') is-invalid @enderror" 
                                                   name="second_phone_number" id="second_phone_number"
                                                   placeholder="Optional secondary number" 
                                                   value="{{ old('second_phone_number', $student->second_phone_number ?? '') }}">
                                            @error('second_phone_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                                      name="address" id="address" rows="3"
                                                      placeholder="Enter full address">{{ old('address', $student->address ?? '') }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Notes Section -->
                                <h5 class="mb-3 mt-4 text-primary"><i class="ti-notepad"></i> Additional Notes</h5>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="notes" class="form-label">Notes</label>
                                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                                      name="notes" id="notes" rows="3"
                                                      placeholder="Any additional notes about this student...">{{ old('notes', $student->notes ?? '') }}</textarea>
                                            @error('notes')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ti-save"></i> {{ isset($student) ? 'Update Student' : 'Save Student' }}
                                    </button>
                                    <a class="btn btn-light" href="/student">
                                        <i class="ti-close"></i> Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
