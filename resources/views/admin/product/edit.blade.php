@extends('layout.main')

@section('content')
<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-md-3">
            @include('include.sidebar')
        </div>
        <div class="col-md-9">
            <div class="card shadow-lg">
                <div class="card-header text-white" style="background-color: #37251b;">
                    <h2>Edit Product</h2>
                </div>
                <div class="card-body bg-light">
                    <form method="post" action="{{ route('admin.product.update', $product->product_id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="product_name">Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" value="{{ $product->product_name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ $product->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="type_id">Type</label>
                            <select class="form-control" id="type_id" name="type_id" required>
                                @foreach($types as $type)
                                    <option value="{{ $type->type_id }}" @if($type->type_id == $product->type_id) selected @endif>{{ $type->type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ $product->price }}" required>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $product->quantity }}" required>
                        </div>
                        <div class="form-group">
                            <label for="alert_stock">Alert Stock</label>
                            <input type="number" class="form-control" id="alert_stock" name="alert_stock" value="{{ $product->alert_stock }}">
                        </div>
                        <div class="form-group">
                            <label for="image">Product Image</label>
                            @if($product->product_image)
                                <div>
                                    <img src="{{ asset('storage/img/product/' . $product->product_image) }}" alt="{{ $product->product_name }}" style="max-width: 200px;">
                                </div>
                            @endif
                            <input type="file" class="form-control-file" id="image" name="product_image">
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="submit" class="btn btn-primary">Update Product</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
