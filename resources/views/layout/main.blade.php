<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/employee.css') }}">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }
        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .filter-btn.active {
            background-color: #007bff;
            color: white;
        }
        .filter-btn {
            transition: background-color 0.3s;
        }
        .filter-btn:hover {
            background-color: #0056b3;
            color: white;
        }
        .card-header {
            background-color: #343a40;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        @yield('content')
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
