<?php

namespace App\Models;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'car_brand', 'car_model', 'car_year', 'slug', 'status'
    ];

    public function getFullNameAttribute(): string
    {
        return "{$this->car_brand} {$this->car_model} ({$this->car_year})";
    }

       public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\Product','brand_id','id')->where('status','active');
    }


    public static function getProductByBrand($slug)
    {
        return self::with('products')->where('slug', $slug)->first();
    }
}
