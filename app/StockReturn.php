<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class StockReturn extends Model
{
    //
    use SoftDeletes;
    use Userstamps;
    protected $table = 'stock_return';

    function returnItems()
    {
        return $this->hasMany(StockReturnItems::class, 'return_id', 'id');
    }

    function billers()
    {
        return $this->hasOne(Biller::class, 'id', 'biller');
    }

    function customers()
    {
        return $this->hasOne(Customer::class, 'id', 'customer');
    }

    function locations()
    {
        return $this->hasOne(Locations::class, 'id', 'location');
    }

}
