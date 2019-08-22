<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    protected $table = 'stock';
//    protected $primaryKey = 'receive_code'; // or null
    use SoftDeletes;
    protected $fillable = ['receive_code', 'receive_date', 'remarks','location'];

    function stockItems()
    {
        return $this->hasMany(StockItems::class, 'stock_id', 'id');
    }

    function qtyAddedSum()
    {
        return $this->hasMany(StockItems::class, 'stock_id', 'id')
            ->selectRaw('stock_items.*, sum(qty) as sum')
            ->where('stock_items.method', '=', 'A')
            ->havingRaw('sum > ?', [0])->groupBy('stock_items.item_id');
    }

    function qtySubsSum()
    {
        return $this->hasMany(StockItems::class, 'stock_id', 'id')
            ->selectRaw('stock_items.*, sum(qty) as sum')
            ->where('stock_items.method', '=', 'S')
            ->havingRaw('sum > ?', [0])->groupBy('stock_items.item_id');
    }
}
