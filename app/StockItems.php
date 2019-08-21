<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockItems extends Model
{
    protected $table ='stock_items';

    function products()
    {
        return $this->hasOne(Products::class, 'id', 'item_id');
    }

}
