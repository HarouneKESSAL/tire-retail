<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'cat_id' => 3,  // Assuming category with ID 1 exists
            'brand_id' => 1,  // Assuming brand with ID 1 exists
            'child_cat_id' => 3,  // Assuming child category with ID 1 exists
            'title' => 'Example Product 1',
            'slug' => 'example-product-1',
            'description' => 'Description for example product 1',
            'summary' => 'Summary for example product 1',
            'price' => 100.00,
            'width' => 195,
            'discount' => 10,
            'aspect_ratio' => 65,
            'diameter' => 15,
            'year' => 2021,
            'car_brand' => 'Honda',
            'model' => 'Civic',
            'option' => 'DX',
            'season' => 'summer',
            'status' => 'active',
            'photo' => 'product1.jpg',
            'is_featured' => 1
        ]);
    }
}
