<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'value', 'is_boolean'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_option_product', 'product_option_id', 'product_id')
            ->withTimestamps();
    }
}
