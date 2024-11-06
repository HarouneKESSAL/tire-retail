<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $brand = Brand::orderBy('id', 'DESC')->paginate();

        return view('backend.brand.index')->with('brands', $brand);
    }

    public function create()
    {
        return view('backend.brand.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'car_brand' => 'string|required',
            'car_model' => 'string|required',
            'car_year' => 'integer|required',
            'option' => 'required|string',
        ]);
        $data = $request->all();
        $slug = Str::slug("{$request->car_brand} {$request->car_model} {$request->car_year}");
        $count = Brand::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug.'-'.date('ymdis').'-'.rand(0, 999);
        }
        $data['slug'] = $slug;
        $status = Brand::create($data);
        if ($status) {
            request()->session()->flash('success', 'Brand successfully created');
        } else {
            request()->session()->flash('error', 'Error, Please try again');
        }

        return redirect()->route('brand.index');
    }

    public function edit($id)
    {
        $brand = Brand::find($id);
        if (! $brand) {
            request()->session()->flash('error', 'Brand not found');
        }

        return view('backend.brand.edit')->with('brand', $brand);
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::find($id);
        $this->validate($request, [
            'car_brand' => 'string|required',
            'car_model' => 'string|required',
            'car_year' => 'integer|required',
            'option' => 'required|string',
        ]);
        $data = $request->all();
        $status = $brand->fill($data)->save();
        if ($status) {
            request()->session()->flash('success', 'Brand successfully updated');
        } else {
            request()->session()->flash('error', 'Error, Please try again');
        }

        return redirect()->route('brand.index');
    }

    public function destroy($id)
    {
        $brand = Brand::find($id);
        if ($brand) {
            $status = $brand->delete();
            if ($status) {
                request()->session()->flash('success', 'Brand successfully deleted');
            } else {
                request()->session()->flash('error', 'Error, Please try again');
            }

            return redirect()->route('brand.index');
        } else {
            request()->session()->flash('error', 'Brand not found');

            return redirect()->back();
        }
    }
}
