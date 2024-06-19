<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Statistics Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .card {
            margin-bottom: 20px;
        }
        .card-body {
            padding: 15px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .table td {
            vertical-align: top;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Transaction Statistics Receipt</h1>

        <div class="card bg-primary text-white">
            <div class="card-body">
                <h4 class="card-title">Total Transactions</h4>
                <p class="card-text">{{ $totalTransactions }}</p>
            </div>
        </div>

        <div class="card bg-success text-white">
            <div class="card-body">
                <h4 class="card-title">Total Sales</h4>
                <p class="card-text">${{ number_format($totalSales, 2) }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Latest Transactions</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
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
        </div>
    </div>
</body>
</html>
