<?php

namespace App\Models;

use App\Http\Queryable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;
class Product extends Model
{
    use Queryable;
    protected $fillable = [
        'title', 'slug', 'summary', 'description', 'cat_id', 'child_cat_id', 'price',
        'brand_id', 'discount', 'status', 'photo', 'size', 'stock', 'is_featured',
        'condition', 'width', 'aspect_ratio', 'diameter', 'season','choix_equipe'
    ];

    /**
     * Scope a query to only include active products.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include featured products.
     *
     * @param Builder $query
     * @return Builder
     */

    public function scopeFeatured(Builder $query)
    {
        return $query->where('is_featured', 1);
    }

    /**
     * Scope a query to only include products in stock.
     *
     * @param Builder $query
     * @return Builder
     */

    public function scopeInStock(Builder $query)
    {
        return $query->where('stock', '>', 0);
    }
    // Many-to-Many relationship with ProductOption
    public function options()
    {
        return $this->belongsToMany(ProductOption::class, 'product_option_product', 'product_id', 'product_option_id')
            ->withTimestamps();
    }

    public function cat_info()
    {
        return $this->hasOne('App\Models\Category', 'id', 'cat_id');
    }

    public function sub_cat_info()
    {
        return $this->hasOne('App\Models\Category', 'id', 'child_cat_id');
    }

    public static function getAllProduct()
    {
        return Product::with(['cat_info', 'sub_cat_info'])->orderBy('id', 'desc')->paginate(10);
    }

    public function rel_prods()
    {
        return $this->hasMany('App\Models\Product', 'cat_id', 'cat_id')->where('status', 'active')->orderBy('id', 'DESC')->limit(8);
    }

    public function getReview()
    {
        return $this->hasMany('App\Models\ProductReview', 'product_id', 'id')->with('user_info')->where('status', 'active')->orderBy('id', 'DESC');
    }

    public static function getProductBySlug($slug)
    {
        return Product::with(['cat_info', 'rel_prods', 'getReview'])->where('slug', $slug)->first();
    }

    public static function countActiveProduct()
    {
        $data = Product::where('status', 'active')->count();
        if ($data) {
            return $data;
        }
        return 0;
    }

    public function carts()
    {
        return $this->hasMany(Cart::class)->whereNotNull('order_id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class)->whereNotNull('cart_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }


}
