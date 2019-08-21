<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    protected $table = 'stock';
    use SoftDeletes;

    function stockItems()
    {
        return $this->hasMany(StockItems::class, 'stock_id', 'id');
    }

    function qtySum()
    {
        return $this->hasMany(StockItems::class, 'stock_id', 'id')
            ->selectRaw('stock_items.*, sum(qty) as sum')
            ->havingRaw('sum > ?', [0])->groupBy('stock_items.item_id');
    }
}
