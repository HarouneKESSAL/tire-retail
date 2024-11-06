<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    public function collection(): Collection
    {
        return Product::with(['category', 'brands'])->get()->map(function ($product) {
//            dd($product->brands);
            return [
                'CODE'             => $product->code,
                'BRAND'            => $product->brand,
                'MODEL'            => $product->model,
                'CATEGORY'         => optional($product->category)->title,
                'CAR' => optional($product->brands)->car_name,

                'SERVICE TYPE'     => $product->service_type,
                'WIDTH'            => $product->width,
                'PROFILE'          => $product->aspect_ratio,
                'CONSTRUCTION'     => 'R',
                'WHEEL DIAMETER'   => $product->diameter,
                'LOAD RATING'      => $product->load_index,
                'SPEED RATING'     => $product->speed_index,
                'LOAD DESCRIPTION' => $product->load_index . $product->speed_index,
                'RUN FLAT'         => $product->runflat,
                'REINFORCED'       => $product->pneu_renforce,
                'EXTRA LOAD'       => $product->extra_load,
                'SHIPPING WEIGHT'  => $product->shipping_weight,
                'DESCRIPTION'      => $product->description,
                'IMAGE'            => $product->photo,
                'STOCK'            => $product->stock,
                'PRICE'            => $product->price,
                'SEASON'           => $product->season,
            ];
        });

    }

    public function headings(): array
    {
        return [
            'CODE',
            'BRAND',
            'MODEL',
            'CATEGORY',
            'CAR',
            'SERVICE TYPE',
            'WIDTH',
            'PROFILE',
            'CONSTRUCTION',
            'WHEEL DIAMETER',
            'LOAD RATING',
            'SPEED RATING',
            'LOAD DESCRIPTION',
            'RUN FLAT',
            'REINFORCED',
            'EXTRA LOAD',
            'SHIPPING WEIGHT',
            'DESCRIPTION',
            'IMAGE',
            'STOCK',
            'PRICE',
            'SEASON',
        ];
    }
}
