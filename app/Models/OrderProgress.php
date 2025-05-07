<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProgress extends Model
{
    protected $table = 'order_progress';

    protected $fillable = [
        'order_id',
        'code_order',
        'name_progress',
        'finishing',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
