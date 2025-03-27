<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    // use HasFactory, SoftDeletes;
    protected $fillable = [
        'category_id',
        'supplier_id',
        'code_product',
        'name_product',
        'description',
        'price',
        'stock',
        'length',
        'width',
        'height',
        'weight',
        'thumbnail',
        'status'
    ];

    // public function category()
    // {
    //     return $this->belongsTo(Category::class, 'category_id', 'id');
    // }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImg::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function productStocks()
    {
        return $this->hasMany(ProductStock::class, 'product_code', 'code_product');
    }

}
