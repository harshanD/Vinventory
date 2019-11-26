<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class PO extends Model
{
    //
    use SoftDeletes;
    public $timestamps = true;
    protected $table = 'po_header';
    use Userstamps;

    function poDetails()
    {
        return $this->hasMany(PoDetails::class, 'po_header', 'id')->with('product');
    }

    public function suppliers()
    {
        return $this->hasOne(Supplier::class, 'id', 'supplier');
    }

    public function locations()
    {
        return $this->hasOne(Locations::class, 'id', 'location');
    }


}
