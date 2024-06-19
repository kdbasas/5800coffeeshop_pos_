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
                        <h1 class="card-title" style="color: white;">Product Types</h1>
                        <a href="{{ route('admin.product_types.create') }}" class="btn btn-success">Add Product Type</a>
                    </div>
                </div>  
                <div class="card-body" style="background-color: #fff;"> <!-- Corrected background color to white -->
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <div class="table-responsive" style="max-height: calc(100vh - 200px); overflow-y: auto;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Type Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productTypes as $type)
                                    <tr>
                                        <td>{{ $type->type_name }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.product_types.edit', $type->type_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="{{ route('admin.product_types.delete', $type->type_id) }}" class="btn btn-danger btn-sm">Delete</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
