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
                    <h1 class="card-title" style="color: white;">Edit Product Type</h1>
                </div>
                <div class="card-body" style="background-color: #ffffff;">
                    <div class="card mt-3">
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.product_types.update', $productType->type_id) }}">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="type_name" class="form-label">Type Name</label>
                                    <input type="text" class="form-control" id="type_name" name="type_name" value="{{ old('type_name', $productType->type_name) }}" required>
                                    @error('type_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <button type="submit" class="btn btn-success w-100">Update Type</button>
                                    </div>
                                    <div class="col-sm-3">
                                        <a href="{{ route('admin.product_types.index') }}" class="btn btn-secondary w-100">Back</a>
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
@endsection
