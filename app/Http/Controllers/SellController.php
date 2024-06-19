<?php

namespace App\Http\Controllers;

use App\Models\ProductType;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Transaction;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SellController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $types = ProductType::all();
        $cartItems = Cart::with('product')->get();
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
        $customerName = '';
        $paymentMethods = ['cash', 'debit_card', 'credit_card'];
        \Log::info('Payment Methods:', $paymentMethods);
        
        return view('employee.sell', compact('products', 'cartItems', 'total', 'customerName', 'types', 'paymentMethods'));
    }

    public function addToCart(Request $request)
{
    try {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);
        $customerName = $request->input('customer_name');
        $employeeId = auth()->user()->employee_id;

        // Find the product
        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['success' => false, 'error' => 'Product not found.']);
        }

        // Check if requested quantity exceeds available stock
        if ($quantity > $product->quantity) {
            return response()->json(['success' => false, 'error' => 'Insufficient stock.']);
        }

        // Check if there's already an item in the cart for this product
        $cartItem = Cart::where('product_id', $productId)->first();

        if ($cartItem) {
            // Update quantity in existing cart item
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // Create new cart item
            $cartItem = Cart::create([
                'employee_id' => $employeeId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);
        }

        // Deduct from product stock
        $product->quantity -= $quantity;
        $product->alert_stock -= $quantity; // Adjust alert stock
        $product->save();

        // Refresh cart and total
        $cartItems = Cart::with('product')->get();
        $newTotal = $this->calculateNewTotal();
        $cartHtml = view('partials.cart_item', compact('cartItems'))->render();

        return response()->json([
            'success' => true,
            'cartHtml' => $cartHtml,
            'new_total' => $newTotal,
            'product_alert_stock' => $product->alert_stock // Return new alert stock value
        ]);

    } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Error adding product to cart: ' . $e->getMessage());
        return response()->json(['success' => false, 'error' => 'Failed to add product to cart. Please try again.']);
    }
}

public function updateQuantity(Request $request, $cartId)
{
    $request->validate([
        'quantity' => 'required|integer|min:1',
    ]);

    try {
        $cartItem = Cart::findOrFail($cartId);
        $product = $cartItem->product;

        // Calculate change in quantity
        $quantityDifference = $request->quantity - $cartItem->quantity;

        // Check if requested quantity exceeds available stock
        if ($request->quantity > $product->quantity) {
            return response()->json(['error' => 'Insufficient stock.'], 400);
        }

        // Update product stock and alert stock accordingly
        $product->quantity -= $quantityDifference;
        $product->alert_stock -= $quantityDifference; // Adjust alert stock
        $product->save();

        // Update cart item quantity
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        // Calculate new total
        $newTotal = $this->calculateNewTotal();

        return response()->json([
            'cartItem' => $cartItem,
            'new_total' => $newTotal,
            'product_alert_stock' => $product->alert_stock,
        ]);
    } catch (\Exception $e) {
        \Log::error('Error updating quantity: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to update quantity. Please try again.'], 500);
    }
}



private function calculateNewTotal()
{
    $cartItems = Cart::all();
    return $cartItems->sum(function ($item) {
        return $item->product->price * $item->quantity;
    });
}


public function removeFromCart($id)
{
    $cartItem = Cart::find($id);

    if (!$cartItem) {
        return response()->json(['error' => 'Cart item not found.'], 404);
    }

    $product = Product::find($cartItem->product_id);
    $product->quantity += $cartItem->quantity;
    $product->alert_stock += $cartItem->quantity; // Restore alert stock
    $product->save();

    $cartItem->delete();

    // Recalculate total and update UI
    $cartItems = Cart::with('product')->get();
    $newTotal = $this->calculateNewTotal();

    return response()->json([
        'new_total' => $newTotal,
        'product_id' => $product->id,
        'product_alert_stock' => $product->alert_stock // Return new alert stock value
    ]);
}



    public function clearCart()
    {
        $cartItems = Cart::all();
        foreach ($cartItems as $cartItem) {
            $product = Product::find($cartItem->product_id);
            $product->quantity += $cartItem->quantity;
            $product->alert_stock += $cartItem->quantity; // Restore alert stock
            $product->save();
            $cartItem->delete();
        }

        return redirect()->route('employee.sell.index');
    }
    public function filterProducts(Request $request)
    {
        $typeId = $request->type_id;$products = Product::where('type_id', $typeId)->get();
        $productsHtml = view('partials.product_list', compact('products'))->render();return response()->json(['productsHtml' => $productsHtml]);
    }
    
    public function checkout(Request $request)
    {
        $employeeId = auth()->user()->employee_id;
    
        // Retrieve all cart items for the current employee
        $cartItems = Cart::where('employee_id', $employeeId)->with('product')->get();
    
        if ($cartItems->isEmpty()) {
            return redirect()->route('employee.sell.index')->with('error', 'No items in the cart.');
        }
    
        $customerName = $request->input('customer_name');
        $amountPaid = $request->input('paid_amount');
        $paymentMethod = $request->input('payment_method');
    
        try {
            DB::beginTransaction();
    
            // Create a single transaction record
            $transaction = new Transaction();
            $transaction->customer_name = $customerName;
            $transaction->paid_amount = $amountPaid;
            $transaction->payment_method = $paymentMethod;
            $transaction->transac_date = now();
            $transaction->user_id = auth()->user()->id; // Assuming you're using authentication
            $transaction->transac_amount = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });
            $transaction->save();
    
            // Associate products with the transaction
            foreach ($cartItems as $cartItem) {
                $transaction->products()->attach($cartItem->product_id, ['quantity' => $cartItem->quantity]);
    
                // Update product quantity after purchase
                $product = $cartItem->product;
                $product->quantity -= $cartItem->quantity;
                $product->save();
            }
    
            // Clear the cart after successful checkout
            Cart::where('employee_id', $employeeId)->delete();
    
            DB::commit();
    
            // Generate and display receipt
            return $this->generateReceipt($transaction);
    
        } catch (\Exception $e) {
            DB::rollBack();
    
            return redirect()->route('employee.sell.index')->with('error', 'Failed to process the order. Please try again later.');
        }
    }    

    public function generateReceipt(Transaction $transaction)
    {
        try {
            // Calculate balance
            $balance = $transaction->paid_amount - $transaction->transac_amount;
    
            // Setup Dompdf with options
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $dompdf = new Dompdf($options);
    
            // Retrieve the view content for the receipt
            $html = view('receipt.show', compact('transaction', 'balance'))->render();
    
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
    
            // Output the generated PDF to the browser
            $output = $dompdf->output();
    
            // Display PDF in browser
            return response($output, 200)->header('Content-Type', 'application/pdf');
    
        } catch (\Exception $e) {
            \Log::error('Error generating receipt: ' . $e->getMessage());
            return redirect()->route('employee.sell.index')->with('error', 'Failed to generate receipt.');
        }
    }
}
    
