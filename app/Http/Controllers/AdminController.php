<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Employee;
use App\Models\Transaction;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\DB; // Import the DB facade here
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    
    public function showStatistics()
{
    // Total Transactions
    $totalTransactions = Transaction::count();

    // Total Sales
    $totalSales = Transaction::sum('transac_amount');

    // Average Sales
    $averageSales = Transaction::avg('transac_amount');

    // Latest Transactions with Product Information
    $latestTransactions = Transaction::with('products')->latest()->take(5)->get();

    // Monthly Sales Data
    $monthlySalesData = Transaction::select(DB::raw('YEAR(transac_date) as year'), DB::raw('MONTH(transac_date) as month'), DB::raw('SUM(transac_amount) as total_sales'))
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->limit(6)
        ->get();

        $printable = view('admin.statistics_receipt', compact('totalTransactions', 'totalSales', 'latestTransactions', 'monthlySalesData'))->render();

        // Return regular statistics view with printable content
        return view('admin.statistics', compact('totalTransactions', 'totalSales', 'averageSales', 'latestTransactions', 'monthlySalesData'))
            ->with('printable', $printable);
    }
    public function mostPurchasedProduct()
{
    $mostPurchasedProduct = Product::select('products.*', DB::raw('SUM(product_transaction.quantity) as total_quantity_sold'))
        ->join('product_transaction', 'products.product_id', '=', 'product_transaction.product_id')
        ->groupBy('products.product_id')
        ->orderByDesc('total_quantity_sold')
        ->first();

    return view('admin.statistics', compact('mostPurchasedProduct'));
}
public function generateStatisticsReceipt()
{
    // Retrieve data as before
    $totalTransactions = Transaction::count();
    $totalSales = Transaction::sum('transac_amount');
    $latestTransactions = Transaction::with('products')->latest()->take(5)->get();
    $monthlySalesData = Transaction::select(DB::raw('YEAR(transac_date) as year'), DB::raw('MONTH(transac_date) as month'), DB::raw('SUM(transac_amount) as total_sales'))
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->limit(6)
        ->get();

    // Setup Dompdf with options
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $dompdf = new Dompdf($options);

    // Retrieve the view content for the receipt
    $html = view('admin.statistics_receipt', compact('totalTransactions', 'totalSales', 'latestTransactions', 'monthlySalesData'))->render();

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Output the generated PDF (inline view in browser)
    $dompdf->stream('transaction_statistics.pdf', ['Attachment' => false]);
}
}