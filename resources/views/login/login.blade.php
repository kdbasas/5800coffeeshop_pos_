@extends('layout.main')

@section('content')
    <style>
        body {
            background-image: url('{{ asset("img/background.png") }}');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            width: 400px;
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #9b8d73;
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            text-align: center;
            padding: 20px;
        }

        .card-header img {
            max-height: 100px;
            margin-bottom: 10px;
        }

        .card-header h3 {
            margin: 0;
            font-size: 18px;
        }

        .card-body {
            padding: 50px;
        }

        .form-label {
            font-weight: bold;
            color: #8B4513;
        }

        .btn-primary {
            background-color: #9b8d73;
            border: 1px solid #9b8d73;
            transition: background-color 0.3s ease;
            border-radius: 25px;
            padding: 12px 40px;
            font-size: 16px;
            color: white;
            cursor: pointer;
            margin-top: 20px;
            width: 100%;
            text-align: center;
        }

        .btn-primary:hover {
            background-color: #703C1F;
        }

        .input-group {
            position: relative;
            width: 100%;
            margin-bottom: 20px;
        }

        .input-group .form-control {
            height: 50px;
            width: calc(100% - 40px);
            padding-left: 40px;
            font-size: 16px;
            border-radius: 20px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .input-group i {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            font-size: 18px;
            color: #8B4513;
        }
    </style>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <img src="{{ asset('img/5800 logo.png') }}" alt="Logo">
                <h3>User Authentication</h3>
            </div>
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger mb-3" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger mb-3" role="alert">
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </div>
                @endif
                <form action="{{ route('login.submit') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="input-group mb-3">
                        <i class="fas fa-envelope"></i>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email" autocomplete="new-email">
                    </div>
                    <div class="input-group mb-3">
                        <i class="fas fa-lock"></i>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="new-password">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
            </div>
        </div>
    </div>
@endsection
