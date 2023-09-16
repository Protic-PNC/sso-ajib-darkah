<?php

namespace App\Models;

use App\Models\ImageProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'slug',
        'description',
        'harga',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function images()
    {
        return $this->hasMany(ImageProduct::class);
    }
}
