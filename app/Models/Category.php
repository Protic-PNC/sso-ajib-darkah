<?php

namespace App\Models;

use App\Models\Product;
use App\Models\ImageCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'slug'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function images()
    {
        return $this->hasMany(ImageCategory::class);
    }
}
