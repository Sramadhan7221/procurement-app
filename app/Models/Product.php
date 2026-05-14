<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'SKU',
        'Name',
        'CategoryId',
        'BasePrice',
        'UoM',
        'Detail',
        'ProductImage',
        'VendorId',
    ];

    protected $casts = [
        'Detail' => 'array',
    ];
}
