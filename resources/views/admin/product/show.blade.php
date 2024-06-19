@extends('layout.main')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header" style="background-color: #37251b; color: white;">
            <h2 class="mb-0">{{ $product->product_name }}</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    @if($product->product_image)
                        <img src="{{ asset('storage/img/product/' . $product->product_image) }}" alt="{{ $product->product_name }}" class="img-fluid">
                    @else
                        <p>No image available</p>
                    @endif
                </div>
                <div class="col-md-8 mt-3 mt-md-0">
                    <p class="mb-1"><strong>Description:</strong></p>
                    <p class="text-muted">{{ $product->description }}</p>
                    <hr>
                    <p class="mb-1"><strong>Type:</strong></p>
                    <p class="text-muted">{{ $product->type->type_name ?? 'N/A' }}</p>
                    <hr>
                    <p class="mb-1"><strong>Price:</strong></p>
                    <p class="text-muted">${{ number_format($product->price, 2) }}</p>
                    <hr>
                    <p class="mb-1"><strong>Quantity:</strong></p>
                    <p class="text-muted">{{ $product->quantity }}</p>
                    <hr>
                    <p class="mb-1"><strong>Alert Stock:</strong></p>
                    <p class="text-muted">{{ $product->alert_stock }}</p>
                </div>
            </div>
        </div>
        <div class="card-footer bg-light">
            <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">Back to Product List</a>
        </div>
    </div>
</div>
<style>
    body {
        background-color: #F4CD81;
    }
</style>
@endsection
