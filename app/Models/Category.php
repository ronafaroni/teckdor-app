<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    // use HasFactory, SoftDeletes;
    protected $table = 'categories';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name_category',
    ];

    // public function products()
    // {
    //     return $this->hasMany(Product::class, 'id', 'id');
    // }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
