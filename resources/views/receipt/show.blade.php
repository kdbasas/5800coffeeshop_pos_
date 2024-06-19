<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receipt</title>
    <style>
        /* CSS styles for the receipt */
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
        }
        .receipt-header span {
            color: #333; /* Dark color for the text inside asterisks */
        }
        .receipt-header img {
            max-width: 100px; /* Adjust as needed */
        }
        .receipt-info {
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th, table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
        }
        tfoot td {
            text-align: right;
        }
        .product-name {
            width: 40%;
        }
        .product-details {
            width: 60%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="receipt-header">
            **** Receipt ****
        </div>
        <div class="receipt-info">
            <p><strong>Customer Name:</strong> {{ $transaction->customer_name }}</p>
            <p><strong>Date:</strong> {{ $transaction->transac_date }}</p>
            <p><strong>Paid Amount:</strong> ${{ number_format($transaction->paid_amount, 2) }}</p>
            <p><strong>Balance:</strong> ${{ number_format($balance, 2) }}</p>
        </div>
        <table>
            <thead>
                <tr>
                    <th class="product-name">Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->products as $product)
                <tr>
                    <td class="product-name">{{ $product->product_name }}</td>
                    <td>{{ $product->pivot->quantity }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>${{ number_format($product->price * $product->pivot->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"><strong>Total:</strong></td>
                    <td>${{ number_format($transaction->transac_amount, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
