<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockItems extends Model
{
    protected $table = 'stock_items';
    protected $fillable = ['qty', 'cost_price', 'tax_per','item_id','method','created_at','updated_at','stock_id'];

    function products()
    {
        return $this->hasOne(Products::class, 'id', 'item_id');
    }

}
