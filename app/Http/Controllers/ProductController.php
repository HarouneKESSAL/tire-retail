<?php

namespace App\Http\Controllers;

use App\Models\ProductOption;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $products = Product::getAllProduct();
        return view('backend.product.index')->with('products', $products);
    }

    public function create(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $brands = Brand::get();
        $categories = Category::where('is_parent', 1)->get();
        $options = ProductOption::all(); // Retrieve all available options

        return view('backend.product.create')
            ->with('categories', $categories)
            ->with('brands', $brands)
            ->with('options', $options); // Pass the options to the view
    }


    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'title' => 'string|required',
            'summary' => 'string|required',
            'description' => 'string|nullable',
            'photo' => 'string|required',
            'size' => 'nullable',
            'stock' => 'required|numeric',
            'cat_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'child_cat_id' => 'nullable|exists:categories,id',
            'is_featured' => 'sometimes|in:1',
            'status' => 'required|in:active,inactive',
            'condition' => 'required|in:default,new,hot',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'width' => 'required|integer',
            'aspect_ratio' => 'required|integer',
            'diameter' => 'required|integer',
            'season' => 'required|string|in:summer,all-season,winter',
            'options' => 'nullable|array',
            'options.*.id' => 'required_with:options|exists:product_options,id',
            'options.*.value' => 'required_with:options|string',
            'code' => 'nullable|string',  // New field
            'brand' => 'nullable|string',  // New field
            'model' => 'nullable|string',  // New field
        ]);

        $data = $request->all();
        $slug = Str::slug($request->title);
        $count = Product::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $data['slug'] = $slug;
        $data['is_featured'] = $request->input('is_featured', 0);
        $size = $request->input('size');
        $data['size'] = $size ? implode(',', $size) : '';

        $product = Product::create($data);

        if ($product && $request->has('options')) {
            foreach ($request->input('options') as $option) {
                $product->options()->attach($option['id']);
            }
        }

        request()->session()->flash('success', 'Product successfully created');


        return redirect()->route('product.index');
    }

    public function edit($id)
    {
        $brands = Brand::get();
        $product = Product::findOrFail($id);
        $categories = Category::where('is_parent', 1)->get();
        $options = ProductOption::all(); // Retrieve all available options
        $items = Product::where('id', $id)->get();
        return view('backend.product.edit')
            ->with('product', $product)
            ->with('categories', $categories)
            ->with('brands', $brands)
            ->with('options', $options)->with('items', $items);
    }


    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Validation rules
        $this->validate($request, [
            'title' => 'string|required',
            'summary' => 'string|required',
            'description' => 'string|nullable',
            'photo' => 'string|required',
            'size' => 'nullable',
            'stock' => 'required|numeric',
            'cat_id' => 'required|exists:categories,id',
            'child_cat_id' => 'nullable|exists:categories,id',
            'is_featured' => 'sometimes|in:1',
            'brand_id' => 'nullable|exists:brands,id',
            'status' => 'required|in:active,inactive',
            'condition' => 'required|in:default,new,hot',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'width' => 'required|integer',
            'aspect_ratio' => 'required|integer',
            'diameter' => 'required|integer',
            'season' => 'required|string|in:summer,all-season,winter',
            'options' => 'nullable|array',
            'options.*.option_id' => 'required_with:options|exists:product_options,id',
            'options.*.value' => 'required_with:options|string',
            'code' => 'nullable|string',  // New field
            'brand' => 'nullable|string',  // New field
            'model' => 'nullable|string',  // New field
        ]);

        // Prepare data for saving
        $data = $request->all();
        $data['is_featured'] = $request->input('is_featured', 0);

        // Handle size
        if ($request->has('size')) {
            $data['size'] = implode(',', $request->input('size'));
        } else {
            $data['size'] = '';
        }

        // Update the product
        $product->fill($data)->save();

        // Detach existing options in pivot table
        $product->options()->detach();

        // Handle options and update them in the `product_options` table
        if ($request->has('options')) {
            foreach ($request->input('options') as $option) {
                // Find or create the product option with the given value
                $productOption = \App\Models\ProductOption::updateOrCreate(
                    ['id' => $option['option_id']],
                    ['value' => $option['value']]
                );

                // Attach the product and option in the pivot table
                $product->options()->attach($productOption->id);
            }
        }

        request()->session()->flash('success', 'Product successfully updated');
        return redirect()->route('product.index');
    }



    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $status = $product->delete();

        if ($status) {
            request()->session()->flash('success', 'Product successfully deleted');
        } else {
            request()->session()->flash('error', 'Error while deleting product');
        }
        return redirect()->route('product.index');
    }
}
