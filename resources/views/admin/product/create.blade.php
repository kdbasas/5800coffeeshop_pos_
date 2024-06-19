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
                    <h1 class="card-title" style="color: white;">Add Product</h1>
                </div>
                <div class="card-body" style="background-color: #ffffff;">
                    <div class="container mt-4">
                        <div class="card shadow">
                            <div class="card-body">
                                <form method="post" action="{{ route('admin.product.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="product_name" class="form-label">Product Name</label>
                                        <input type="text" class="form-control" id="product_name" name="product_name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="type_id" class="form-label">Type</label>
                                        <select class="form-control" id="type_id" name="type_id" required>
                                            <option value="">Please select an item</option>
                                            @foreach($types as $type)
                                                <option value="{{ $type->type_id }}">{{ $type->type_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price</label>
                                        <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">Quantity</label>
                                        <input type="number" class="form-control" id="quantity" name="quantity" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alert_stock" class="form-label">Alert Stock</label>
                                        <input type="number" class="form-control" id="alert_stock" name="alert_stock" value="100">
                                    </div>
                                    <div class="mb-3">
                                        <label for="product_image" class="form-label">Product Image</label>
                                        <input type="file" class="form-control-file" id="product_image" name="product_image">
                                    </div>
                                    <button type="submit" class="btn btn-success w-100">Add Product</button>
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
