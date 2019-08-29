<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Adjustment extends Model
{
    //
    protected $table = 'adjustment';
    use SoftDeletes;
    use Userstamps;
    protected $fillable = ['reference_code', 'date', 'location', 'note', 'status', 'deleted_at', 'created_at', 'updated_at', 'id'];

    function locations()
    {
        return $this->hasOne(Locations::class, 'id', 'location');
    }

//    function stockAdded()
//    {
//        return $this->hasOne(Stock::class, 'receive_code', 'reference_code');
//    }
//
//    function stockSubs()
//    {
//        return $this->hasOne(Stock::class, 'receive_code', 'reference_code');
//    }


}
