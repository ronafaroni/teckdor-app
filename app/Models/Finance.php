<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    protected $table = 'order_payments';

    protected $primaryKey = 'id';

    protected $fillable = [
        'code_order',
        'order_id',
        'total_payment',
        'payment_status',
        'payment_date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
