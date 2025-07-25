<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'code',
        'sku',
        'name',
        'alias_name',
        'price',
        'description',
    ];

    protected $casts = [
        'price' => 'float',
    ];
}
