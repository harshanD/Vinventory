<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockReturnItems extends Model
{
    protected $table = 'stock_return_details';
    protected $fillable = [
        'qty',
        'selling_price',
        'tax_per',
        'tax_val',
        'discount',
        'sub_total',
        'item_id',
        'return_id',
    ];

    function products()
    {
        return $this->hasOne(Products::class, 'id', 'item_id');
    }
}
