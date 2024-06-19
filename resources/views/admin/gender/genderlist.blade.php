<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gender List</title>
</head>
<body>
@extends('layout.main')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-3 mt-5"> 
            @include('include.sidebar')
        </div>
        <div class="col-md-9">
            <div class="card mt-5">
                <div class="card-header" style="background-color: #37251b;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="card-title" style="color: white;">Gender List</h1>
                        <a href="{{ route('admin.gender.create') }}" class="btn btn-success">Add Gender</a>
                    </div>
                </div>  
                <div class="card-body" style="background-color: #37251b;"> 
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.gender.search') }}" method="GET" class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search by gender" name="search" value="{{ old('search') }}">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Gender</th>
                                    <th>Date Created</th>
                                    <th>Date Updated</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($genders as $gender)
                                    <tr>
                                        <td>{{ $gender->gender }}</td>
                                        <td>{{ $gender->created_at }}</td>
                                        <td>{{ $gender->updated_at }}</td>
                                        <td>
                                            <div class="btn-group">
                                                @isset($gender)
                                                <a href="{{ route('admin.gender.show', $gender->gender_id) }}" class="btn btn-info btn-sm">View</a>
                                                <a href="{{ route('admin.gender.edit', $gender->gender_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="{{ route('admin.gender.delete', $gender->gender_id) }}" class="btn btn-danger btn-sm">Delete</a>
                                                @endisset
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">No genders found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
</body>
</html>
