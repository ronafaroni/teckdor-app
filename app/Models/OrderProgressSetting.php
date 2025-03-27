<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProgressSetting extends Model
{
    protected $table = 'order_progress_settings';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name_progress',
    ];
}
