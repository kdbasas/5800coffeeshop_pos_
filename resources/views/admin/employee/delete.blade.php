@extends('layout.main')

@section('content')
<div class="container">
    <div class="row justify-content-center"> 
        <div class="col-md-6"> 
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title">Delete Employee</h1>
                    <p>Are you sure you want to delete this employee?</p>
                    <form action="{{ route('admin.employee.destroy', $employee->employee_id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                        <a href="{{ route('admin.employee.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
