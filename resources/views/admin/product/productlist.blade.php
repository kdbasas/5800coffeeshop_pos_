@extends('layout.main')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 mt-5"> 
            @include('include.sidebar')
        </div>
        <div class="col-md-9">
            <div class="card mt-5">
                <div class="card-header" style="background-color: #37251b;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="card-title" style="color: white;">All Products</h1>
                        <a href="{{ route('admin.product.create') }}" class="btn btn-success">Add Product</a>
                    </div>
                </div>  
                <div class="card-body" style="background-color: #ffffff;"> 
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form action="{{ route('admin.productlist.search') }}" method="GET" class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search by name" name="search" value="{{ request('search') }}">
                            <select name="type" class="form-control">
                                <option value="">All Types</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->type_id }}" {{ $type->type_id == request('type') ? 'selected' : '' }}>
                                        {{ $type->type_name }}
                                    </option>
                                @endforeach
                            </select>
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </form>
                    
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        @forelse($products as $product)
                        <div class="col">
                            <div class="card h-100">
                                <img src="{{ asset('storage/img/product/' . $product->product_image) }}" class="card-img-top" alt="{{ $product->product_name }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->product_name }}</h5>
                                    <p class="card-text">{{ $product->description }}</p>
                                    <p class="card-text"><strong>Type:</strong> {{ $product->type->type_name }}</p>
                                    <p class="card-text"><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                                    <p class="card-text"><strong>Quantity:</strong> {{ $product->quantity }}</p>
                                    <p class="card-text"><strong>Alert Stock:</strong> {{ $product->alert_stock }}</p>
                                </div>
                                <div class="card-footer">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.product.show', $product->product_id) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('admin.product.edit', $product->product_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="{{ route('admin.product.delete', $product->product_id) }}" class="btn btn-danger btn-sm">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-body">
                                    <p class="card-text">No products found.</p>
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div> 
                    {{ $products->appends(['type' => request('type')])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
