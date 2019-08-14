<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PO extends Model
{
    //
    use SoftDeletes;
    public $timestamps = true;
    protected $table = 'po_header';

    function poDetails()
    {
        return $this->hasMany(poDetails::class, 'po_header', 'id');
    }

    public function suppliers()
    {
        return $this->hasOne(Supplier::class, 'id', 'supplier');
    }


}
