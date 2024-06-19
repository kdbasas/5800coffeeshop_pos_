<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Statistics</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    @yield('styles')
    <style>
        body {
            background-color: #F4CD81;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mb-4"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        <h1>Transaction Statistics</h1>
        <a href="{{ route('admin.statistics.receipt') }}" class="btn btn-primary mb-4">Print Receipt</a>
        <div class="row">
            <div class="col-md-6 col-sm-12 mb-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h4 class="card-title">Total Transactions</h4>
                        <p class="card-text">{{ $totalTransactions }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 mb-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h4 class="card-title">Total Sales</h4>
                        <p class="card-text">${{ number_format($totalSales, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Display latest transactions -->
        <div class="card mt-4">
            <div class="card-header">
                <h4>Latest Transactions</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Date</th>
                                <th>Customer Name</th>
                                <th>Total Amount</th>
                                <th>Payment Method</th>
                                <th>Products</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($latestTransactions as $transaction)
                            <tr>
                                <td>{{ $transaction->transac_date }}</td>
                                <td>{{ $transaction->customer_name }}</td>
                                <td>${{ number_format($transaction->transac_amount, 2) }}</td>
                                <td>{{ ucfirst($transaction->payment_method) }}</td>
                                <td>
                                    <ul>
                                        @foreach ($transaction->products as $product)
                                            <li>{{ $product->product_name }} (Quantity: {{ $product->pivot->quantity }})</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Display monthly sales chart -->
        <div class="card mt-4">
            <div class="card-header">
                <h4>Monthly Sales</h4>
            </div>
            <div class="card-body">
                <canvas id="monthlySalesChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var months = [];
            var salesData = [];

            @foreach ($monthlySalesData as $data)
                months.push("{{ $data->year }}-{{ str_pad($data->month, 2, '0', STR_PAD_LEFT) }}");
                salesData.push({{ $data->total_sales }});
            @endforeach

            var ctx = document.getElementById('monthlySalesChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: months.reverse(),
                    datasets: [{
                        label: 'Monthly Sales',
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        data: salesData.reverse(),
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                callback: function(value) { if (value % 1 === 0) { return value; } }
                            }
                        }]
                    }
                }
            });
        });
    </script>
</body>
</html>
