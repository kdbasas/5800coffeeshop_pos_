    @extends('layout.main')

    @section('content')
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-3 mt-5">
                @include('include.sidebar')
            </div>
            <div class="col-md-9">
                <div class="card shadow-lg mt-5">
                    <div class="card-header text-white" style="background-color: #37251b;">
                        <h2>Edit Employee</h2>
                    </div>
                    <div class="card-body bg-light">
                        <form method="post" action="{{ route('admin.employee.update', $employee->employee_id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $employee->first_name }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="middle_name" class="form-label">Middle Name</label>
                                    <input type="text" class="form-control" id="middle_name" name="middle_name" value="{{ $employee->middle_name }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $employee->last_name }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="suffix_name" class="form-label">Suffix Name</label>
                                    <input type="text" class="form-control" id="suffix_name" name="suffix_name" value="{{ $employee->suffix_name }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $employee->email }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="{{ $employee->phone }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" value="{{ $employee->address }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                    <small class="text-muted">Leave blank if you do not want to change the password</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>                                        
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-select" id="gender" name="gender">
                                        <option value="" selected>Select Gender</option>
                                        @foreach($genders as $gender)
                                        <option value="{{ $gender->gender_id }}" {{ $employee->gender_id == $gender->gender_id ? 'selected' : '' }}>{{ $gender->gender }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="admin" class="form-label">Is Admin?</label>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="admin" name="admin" value="1" @if($employee->admin) checked @endif>
                                        <label class="form-check-label" for="admin">Admin</label>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="is_employee" name="is_employee" value="1" @if($employee->is_employee) checked @endif>
                                        <label class="form-check-label" for="is_employee">Is Employee?</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="employee_image" class="form-label">Employee Image</label>
                                    <input type="file" class="form-control" id="employee_image" name="employee_image">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-between">
                                    <button type="submit" class="btn btn-success">Update Employee</button>
                                    <a href="{{ route('admin.employee.index') }}" class="btn btn-secondary">Back</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
