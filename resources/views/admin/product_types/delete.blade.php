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
                    <h1 class="card-title" style="color: white;">Delete Product Type</h1>
                </div>
                <div class="card-body" style="background-color: #ffffff;">
                    <div class="card mt-3">
                        <div class="card-body">
                            <p class="card-text">Are you sure you want to delete this Product Type named "{{ $productType->type_name }}"?</p>
                            <form action="{{ route('admin.product_types.destroy', $productType->type_id) }}" method="post">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger col-sm-3 float-end">Yes</button>
                            </form>
                            <a href="{{ route('admin.product_types.index') }}" class="btn btn-secondary col-sm-3 float-end me-1">No</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
