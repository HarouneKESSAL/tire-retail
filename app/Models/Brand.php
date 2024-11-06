<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'car_brand', 'car_model', 'car_year', 'slug', 'status', 'option','car_name'
    ];

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\Product', 'brand_id', 'id')->where('status', 'active');
    }

    public static function getProductByBrand($slug)
    {
        return self::with('products')->where('slug', $slug)->first();
    }
}
