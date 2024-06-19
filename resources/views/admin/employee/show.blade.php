@extends('layout.main')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header" style="background-color: #37251b; color: white;">
            <h2 class="mb-0">{{ $employee->first_name }} {{ $employee->last_name }}</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-4 mb-3 mb-md-0 text-center">
                    @if($employee->employee_image)
                        <img src="{{ asset('storage/img/employee/' . $employee->employee_image) }}" alt="Employee Image" class="img-fluid rounded">
                    @else
                        <p>No image available</p>
                    @endif
                </div>
                <div class="col-12 col-md-8">
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="mb-1"><strong>Email:</strong></p>
                            <p class="text-muted">{{ $employee->email }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="mb-1"><strong>Phone:</strong></p>
                            <p class="text-muted">{{ $employee->phone }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="mb-1"><strong>Address:</strong></p>
                            <p class="text-muted">{{ $employee->address }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="mb-1"><strong>Gender:</strong></p>
                            <p class="text-muted">{{ $employee->gender->gender ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-light text-center">
            <a href="{{ route('admin.employee.index') }}" class="btn btn-secondary">Back to Employee List</a>
        </div>
    </div>
</div>
<style>
    body {
        background-color: #F4CD81;
    }

    /* Media query for devices with a width less than 576px (small phones) */
    @media (max-width: 575.98px) {
        .card-header h2 {
            font-size: 1.25rem;
        }
        .card-body p {
            font-size: 0.9rem;
        }
        .btn-secondary {
            font-size: 0.8rem;
            padding: 0.5rem 1rem;
        }
    }

    /* Media query for devices with a width between 576px and 767.98px (medium phones) */
    @media (min-width: 576px) and (max-width: 767.98px) {
        .card-header h2 {
            font-size: 1.5rem;
        }
        .card-body p {
            font-size: 1rem;
        }
        .btn-secondary {
            font-size: 0.9rem;
            padding: 0.6rem 1.2rem;
        }
    }

    /* Media query for devices with a width between 768px and 991.98px (tablets) */
    @media (min-width: 768px) and (max-width: 991.98px) {
        .card-header h2 {
            font-size: 1.75rem;
        }
        .card-body p {
            font-size: 1.1rem;
        }
        .btn-secondary {
            font-size: 1rem;
            padding: 0.7rem 1.4rem;
        }
    }

    /* Media query for devices with a width of 992px and above (large devices) */
    @media (min-width: 992px) {
        .card-header h2 {
            font-size: 2rem;
        }
        .card-body p {
            font-size: 1.25rem;
        }
        .btn-secondary {
            font-size: 1.1rem;
            padding: 0.8rem 1.5rem;
        }
    }
</style>
@endsection
