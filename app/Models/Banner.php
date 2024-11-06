<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'photo', 'status'];

    public function scopeActive(Builder $query)
    {
        return $query->where('status', 'active');
    }
}
