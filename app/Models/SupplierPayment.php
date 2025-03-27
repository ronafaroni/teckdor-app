<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierPayment extends Model
{
    protected $table = 'supplier_payments';

    protected $primaryKey = 'id';

    protected $fillable = [
        'code_order',
        'order_id',
        'product_id',
        'supplier_id',
        'total_payment',
        'payment_status',
        'payment_date',
    ];
}
