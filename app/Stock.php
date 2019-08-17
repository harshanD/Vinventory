<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stock';

    function stockItems()
    {
        return $this->hasMany(StockItems::class, 'stock_id', 'id');
    }
}
