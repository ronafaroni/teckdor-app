<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderShipping extends Model
{
    protected $table = 'order_shippings';
    protected $primaryKey = 'id';
    protected $fillable = [
        'code_shipping',
        'order_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderProgress()
    {
        return $this->belongsTo(OrderProgress::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
