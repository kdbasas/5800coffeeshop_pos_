@extends('layout.main')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashier Dashboard</title>
    <style>
        body {
            background-color: #F4CD81; /* Background color for the entire page */
            font-family: Arial, Helvetica, sans-serif;
        }

        .container-fluid {
            padding: 20px;
        }

        .card {
            border-radius: 15px;
            background-color: #37251b;
            color: #fff;
        }

        .card-header {
            background-color: #37251b;
            border-bottom: none;
        }

        .card-title {
            color: #fff;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }

        .alert-success {
            background-color: #28a745;
            color: #fff;
        }

        .alert-info {
            background-color: #17a2b8;
            color: #fff;
        }

        .table {
            background-color: #37251b;
            color: #fff;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(255,255,255,0.05);
        }

        .thead-dark th {
            background-color: #212529;
            color: #fff;
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.05);
            color: #fff;
            border: none;
        }

        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-3 mt-5"> 
            @include('employee.sidebar')
        </div>
        <div class="col-md-9">
            <div class="card mt-5">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="card-title">Cashier Dashboard</h1>
                    </div>
                </div>  
                <div class="card-body"> 
                    <h4 class="card-title">Welcome, {{ Auth::user()->name }}!</h4>
                    <p class="card-text">You are logged in!!</p>
                        @php
                            $employee = App\Models\Employee::where('email', Auth::user()->email)->first();
                        @endphp

                        @if($employee)
                            <img src="{{ asset('storage/img/employee/' . $employee->employee_image) }}" alt="Employee Image" class="img-fluid rounded-circle" style="max-width: 150px; max-height: 150px;">
                        @else
                            <p>No image available</p>
                        @endif
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>
</body>
</html>
@endsection
