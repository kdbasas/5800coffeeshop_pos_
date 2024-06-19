<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\DB; // Import the DB facade
use App\Models\Cart;
use App\Models\Product;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string',
            'transac_amount' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
        ]);

        $transaction = new Transaction();
        $transaction->customer_name = $request->customer_name;
        $transaction->transac_amount = $request->transac_amount;
        $transaction->paid_amount = $request->paid_amount;
        $transaction->balance = $request->transac_amount - $request->paid_amount;
        $transaction->payment_method = $request->payment_method;
        $transaction->user_id = auth()->id(); // Assuming you're using authentication
        $transaction->transac_date = now();
        $transaction->save();

        // Update product quantities based on the transaction
        $cartItems = Cart::where('employee_id', auth()->id())->get();
        foreach ($cartItems as $cartItem) {
            $product = Product::find($cartItem->product_id);
            if ($product) {
                $product->quantity -= $cartItem->quantity;
                $product->save();
            }
        }

        // Clear the cart after the transaction
        Cart::where('employee_id', auth()->id())->delete();

        // Generate PDF receipt
        $this->generateReceipt($transaction);

        return redirect()->route('admin.statistics')->with('success', 'Transaction completed successfully!');
    }

    public function generateReceipt(Transaction $transaction)
    {
        // Configure Dompdf options
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);

        // Instantiate Dompdf
        $dompdf = new Dompdf($options);

        // Generate HTML for receipt view
        $html = view('receipt.show', compact('transaction'))->render();

        // Load HTML into Dompdf
        $dompdf->loadHtml($html);

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF
        $dompdf->render();

        // Output PDF to browser
        return $dompdf->stream('receipt.pdf');
    }

    public function showReceipt(Transaction $transaction)
    {
        // Ensure only authenticated user can view their own receipts
        if ($transaction->user_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return $this->generateReceipt($transaction);
    }

    public function index()
    {
        // Monthly Sales Data
        $monthlySalesData = Transaction::select(DB::raw('YEAR(transac_date) as year'), DB::raw('MONTH(transac_date) as month'), DB::raw('SUM(transac_amount) as total_sales'))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(6)
            ->get();

        return view('admin.statistics', compact('monthlySalesData'));
    }
}
