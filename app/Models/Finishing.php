<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finishing extends Model
{
    protected $table = 'finishings';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
    ];
}
