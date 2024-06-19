<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductType;

class ProductTypeController extends Controller
{
    public function index()
    {
        $productTypes = ProductType::all();
        return view('admin.product_types.producttypelist', compact('productTypes'));
    }

    public function create()
    {
        return view('admin.product_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_name' => 'required|string|max:255|unique:product_types,type_name',
        ]);

        ProductType::create($request->all());

        return redirect()->route('admin.product_types.index')->with('success', 'Product Type created successfully.');
    }

    public function edit(ProductType $productType)
    {
        return view('admin.product_types.edit', compact('productType'));
    }

    public function update(Request $request, ProductType $productType)
    {
        $request->validate([
            'type_name' => 'required|string|max:255|unique:product_types,type_name,' . $productType->type_id . ',type_id',
        ]);

        $productType->update($request->all());

        return redirect()->route('admin.product_types.index')->with('success', 'Product Type updated successfully.');
    }

    public function delete($id)
    {
        $productType = ProductType::find($id);
        return view('admin.product_types.delete', compact('productType'));
    }
    public function destroy(ProductType $productType)
    {
        $productType->delete();

        return redirect()->route('admin.product_types.index')->with('success', 'Product Type deleted successfully.');
    }
}
