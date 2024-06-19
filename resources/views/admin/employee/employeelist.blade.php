<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee List</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap CSS link -->
</head>
<body>
@extends('layout.main')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-12 mt-5"> <!-- Adjust column sizes for different screen sizes -->
            @include('include.sidebar')
        </div>
        <div class="col-lg-9 col-md-8 col-sm-12">
            <div class="card mt-5">
                <div class="card-header" style="background-color: #37251b;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="card-title" style="color: white;">Employee List</h1>
                        <a href="{{ route('admin.employee.create') }}" class="btn btn-success">Add Employee</a>
                    </div>
                </div>  
                <div class="card-body" style="background-color: #37251b;"> 
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form action="{{ route('admin.employeelist.search') }}" method="GET" class="mb-3">
                        <div class="form-row align-items-center">
                            <div class="col-md-6 col-sm-12 mb-2">
                                <input type="text" class="form-control" placeholder="Search by name" name="search" value="{{ old('search') }}">
                            </div>
                            <div class="col-md-3 col-sm-6 mb-2">
                                <select name="gender" class="form-control">
                                    <option value="">All Genders</option>
                                    @foreach($genders as $gender)
                                        <option value="{{ $gender->gender_id }}" {{ $gender->gender_id == request('gender') ? 'selected' : '' }}>
                                            {{ $gender->gender }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-2">
                                <button class="btn btn-primary btn-block" type="submit">Search</button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Employee Image</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Contact</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($employees as $employee)
                                    <tr>
                                        <td><img src="{{ $employee->employee_image ? asset('storage/img/employee/' . $employee->employee_image) : asset('img/BlankPicture.png') }}" width="75" height="75" class="img-fluid rounded-circle"></td>
                                        <td>
                                            @if ($employee->suffix_name)
                                                {{ $employee->first_name }} {{ $employee->middle_name ? $employee->middle_name . ' ' : '' }}{{ $employee->last_name }} {{ $employee->suffix_name }}
                                            @else
                                                {{ $employee->first_name }} {{ $employee->middle_name ? $employee->middle_name . ' ' : '' }}{{ $employee->last_name }}
                                            @endif
                                        </td>
                                        <td>{{ $employee->gender->gender ?? '' }}</td>
                                        <td>{{ $employee->phone }}</td>
                                        <td>{{ $employee->email }}</td>
                                        <td>
                                            <div class="btn-group">
                                                @isset($employee)
                                                <a href="{{ route('admin.employee.show', $employee->employee_id) }}" class="btn btn-info btn-sm">View</a>
                                                <a href="{{ route('admin.employee.edit', $employee->employee_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="{{ route('admin.employee.delete', $employee->employee_id) }}" class="btn btn-danger btn-sm">Delete</a>
                                                @endisset
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">No employees found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div> 
                        {{ $employees->appends(['gender' => request('gender')])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script> <!-- Bootstrap JS link -->
</body>
</html>
