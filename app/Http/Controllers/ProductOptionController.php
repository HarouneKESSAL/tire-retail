<?php

namespace App\Http\Controllers;

use App\Models\ProductOption;
use Illuminate\Http\Request;

class ProductOptionController extends Controller
{
    public function index()
    {
        $options = ProductOption::all();
        return view('backend.product_options.index', compact('options'));
    }

    public function create()
    {
        return view('backend.product_options.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'is_boolean' => 'sometimes|boolean',
            'value' => $request->has('is_boolean') ? 'nullable' : 'required|string', // Make value nullable if boolean
        ]);

        $productOption = new ProductOption([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'value' => $request->has('is_boolean') ? '1' : $request->input('value'), // Set value to 1 if boolean
            'is_boolean' => $request->has('is_boolean') ? 1 : 0,
        ]);

        $productOption->save();

        return redirect()->route('product-options.index')->with('success', 'Product option created successfully.');
    }



    public function edit(ProductOption $productOption)
    {
        $options = ProductOption::all();
        return view('backend.product_options.edit', compact('productOption', 'options'));
    }

    public function update(Request $request, ProductOption $productOption)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'value' => $request->has('is_boolean') ? 'nullable|string' : 'required|string',
            'is_boolean' => 'sometimes|boolean',
        ]);

        $productOption->name = $request->input('name');
        $productOption->type = $request->input('type');
        $productOption->value = $request->has('is_boolean') ? '' : $request->input('value');
        $productOption->is_boolean = $request->has('is_boolean') ? 1 : 0;

        $productOption->save();

        return redirect()->route('product-options.index')->with('success', 'Product Option updated successfully.');
    }

    public function destroy(ProductOption $productOption)
    {
        $productOption->delete();

        return redirect()->route('product-options.index')->with('success', 'Product Option deleted successfully.');
    }
}
