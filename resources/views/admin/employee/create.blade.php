@extends('layout.main')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-3 mt-5"> 
                @include('include.sidebar')
            </div>
            <div class="col-md-9">
                <div class="card mt-5">
                    <div class="card-header" style="background-color: #37251b;">
                        <h1 class="card-title" style="color: white;">Add Employee</h1>
                    </div>
                    <div class="card-body" style="background-color: #ffffff;">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-9">
                                    <div class="card mt-4">
                                        <div class="card-body">
                                            <h5 class="card-title mb-4"></h5>

                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                            <form action="{{ route('admin.employee.store') }}" method="post" enctype="multipart/form-data">
                                                @csrf

                                                <div class="mb-3">
                                                    <label for="employee_image" class="form-label">Employee Image</label>
                                                    <input type="file" class="form-control" id="employee_image" name="employee_image" value="{{ old('employee_image') }}">
                                                    @error('employee_image')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="first_name" class="form-label">First Name</label>
                                                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                                        @error('first_name')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="middle_name" class="form-label">Middle Name</label>
                                                        <input type="text" class="form-control" id="middle_name" name="middle_name" value="{{ old('middle_name') }}">
                                                        @error('middle_name')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="last_name" class="form-label">Last Name</label>
                                                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                                        @error('last_name')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="suffix_name" class="form-label">Suffix Name</label>
                                                        <input type="text" class="form-control" id="suffix_name" name="suffix_name" value="{{ old('suffix_name') }}">
                                                        @error('suffix_name')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" autocomplete="new-email" required>
                                                    @error('email')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="password" class="form-label">Password</label>
                                                        <input type="password" class="form-control" id="password" name="password" autocomplete="new-password" required>
                                                        @error('password')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                                        @error('password_confirmation')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="phone" class="form-label">Phone</label>
                                                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                                                    @error('phone')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="address" class="form-label">Address</label>
                                                    <textarea class="form-control" id="address" name="address">{{ old('address') }}</textarea>
                                                    @error('address')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="gender" class="form-label">Gender</label>
                                                    <select class="form-select" id="gender" name="gender" required>
                                                        <option value="" selected>Select Gender</option>
                                                        @foreach($genders as $gender)
                                                            <option value="{{ $gender->gender_id }}">{{ $gender->gender }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('gender')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group checkbox mb-3">
                                                    <input type="checkbox" id="admin" name="admin" value="1">
                                                    <label for="admin">Is Admin?</label>
                                                    @error('admin')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3 form-check">
                                                    <input type="checkbox" class="form-check-input" id="is_employee" name="is_employee" value="1">
                                                    <label class="form-check-label" for="is_employee">Is Employee?</label>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <button type="submit" class="btn btn-success w-100">Save</button>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <a href="{{ route('admin.employee.index') }}" class="btn btn-secondary w-100">Back</a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
