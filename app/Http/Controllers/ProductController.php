<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductType;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('type')->paginate(9);
        $types = ProductType::all();
        return view('admin.product.productlist', compact('products', 'types'));
    }

    public function create()
    {
        $types = ProductType::all();
        return view('admin.product.create', compact('types'));
    }

        public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required',
            'description' => 'nullable',
            'type_id' => 'required|exists:product_types,type_id',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'alert_stock' => 'nullable|integer',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('product_image')) {
            $fileNameWithExtension = $request->file("product_image");
            $filename = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);
            $extension = $request->file('product_image')->getClientOriginalExtension();
            $filenameToStore = $filename . '_' . time() . '.' . $extension;
            $request->file('product_image')->storeAs('public/img/product', $filenameToStore);
            $validated['product_image'] = $filenameToStore;
        }
        Product::create($validated);

        return redirect()->route('admin.product.index')->with('success', 'Product added successfully.');
    }   

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $types = ProductType::all();
        return view('admin.product.edit', compact('product', 'types'));
    }

    public function update(Request $request, Product $product)
{
    $validated = $request->validate([
        'product_name' => 'required',
        'description' => 'nullable',
        'type_id' => 'required|exists:product_types,type_id',
        'price' => 'required|numeric',
        'quantity' => 'required|integer',
        'alert_stock' => 'nullable|integer',
        'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->hasFile('product_image')) {
        // Delete old image if exists
        if ($product->product_image && Storage::exists('public/img/product/' . $product->product_image)) {
            Storage::delete('public/img/product/' . $product->product_image);
        }

        // Upload new image
        $fileNameWithExtension = $request->file("product_image");
        $filename = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);
        $extension = $request->file('product_image')->getClientOriginalExtension();
        $filenameToStore = $filename . '_' . time() . '.' . $extension;
        $request->file('product_image')->storeAs('public/img/product', $filenameToStore);
        $validated['product_image'] = $filenameToStore;
    }

    // Update product with validated data
    $product->update($validated);
    
    return redirect()->route('admin.product.index')->with('success', 'Product updated successfully.');
}

    public function delete($id)
    {
        $product = Product::find($id);
        return view('admin.product.delete', compact('product'));
    }
    public function destroy(Product $product)
{
    // Check if product has an image and delete it from storage
    if ($product->product_image && Storage::exists('public/img/product/' . $product->product_image)) {
        Storage::delete('public/img/product/' . $product->product_image);
    }

    // Delete the product
    $product->delete();

    return redirect()->route('admin.product.index')->with('success', 'Product deleted successfully.');
}

    public function search(Request $request)
    {
        $search = $request->input('search');
        $type = $request->input('type');

        $products = Product::with('type')
            ->where(function ($query) use ($search) {
                $query->where('product_name', 'like', "%$search%")
                      ->orWhere('description', 'like', "%$search%");
            });

        if ($type) {
            $products->where('type_id', $type);
        }

        $products = $products->paginate(9);
        $types = ProductType::all();

        return view('admin.product.productlist', compact('products', 'types'));
    }
    public function show(Product $product)
    {
        return view('admin.product.show', compact('product'));
    }
}


