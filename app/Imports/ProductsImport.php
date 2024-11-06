<?php

namespace App\Imports;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Product([
            'code'            => $row['code'],
            'brand'           => $row['brand'],
            'model'           => $row['model'],
//            'cat_id'          => Category::where('title', $row['category'])->first()->id,
//            'brand_id'        => Brand::where('car_name', $row['car'])->first()->id,
            'service_type'    => $row['service_type'],
            'width'           => $row['width'],
            'aspect_ratio'    => $row['profile'],
            'diameter'        => $row['wheel_diameter'],
            'load_index'      => $row['load_rating'],
            'speed_index'     => $row['speed_rating'],
            //if yes then 1 else 0
            'runflat' => isset($row['RUNFLAT']) && $row['RUNFLAT'] == 'yes' ? 1 : 0,

//            'pneu_renforce'   => $row['reinforced'],
//            'extra_load'      => $row['extra_load'],
            'shipping_weight' => $row['shipping_weight'],
            'description'     => $row['description'],
            'photo'           => $row['image'],
            'stock'           => $row['stock'],
            'price'           => $row['price'],
            'season'          => $row['season'],
        ]);
    }
}
