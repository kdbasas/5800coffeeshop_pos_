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
                    <h1 class="card-title" style="color: white;">Add Gender</h1>
                </div>
                <div class="card-body" style="background-color: #ffffff;">
                    <div class="container mt-4">
                        <div class="card shadow">
                            <div class="card-body">

                                <form action="{{ route('admin.gender.store') }}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="gender" class="form-label">Gender</label>
                                        <input type="text" class="form-control" id="gender" name="gender" value="{{ old('gender') }}">
                                        @error('gender')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-success w-100">Add Gender</button>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="{{ route('admin.gender.index') }}" class="btn btn-secondary w-100">Back</a>
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
@endsection
