<?php

namespace Database\Seeders;

use App\Models\ProductReview;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductReview::create([
            'user_id' => 1,  // Assuming user with ID 1 exists
            'product_id' => 1,  // Assuming product with ID 1 exists
            'rate' => 5,
            'review' => 'This is a great product!',
            'status' => 'active'
        ]);
    }
}
