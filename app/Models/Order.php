<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\ProductImg;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    // use HasFactory, SoftDeletes;
    //
    protected $fillable = [
        'product_id',
        'customer_id',
        'code_order',
        'description',
        'length',
        'width',
        'height',
        'qty',
        'img_sample',
        'is_draft',
        'status',
        'payment_status'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImg::class);
    }

    public function orderProgress()
    {
        return $this->hasMany(OrderProgress::class, 'order_id');
    }

    public function orderShipping()
    {
        return $this->hasMany(OrderShipping::class, 'order_id');
    }
}
