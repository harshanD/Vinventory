<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PoDetails extends Model
{
    //
//    use SoftDeletes;
    public $timestamps = true;
    protected $table = 'po_details';
    protected $fillable = array('cost_price', 'qty', 'tax_val', 'discount', 'sub_total','tax_percentage');

    function poHeader()
    {
        return $this->hasOne(poDetails::class, 'po_header');
    }

    public function product()
    {
        return $this->hasOne(Products::class, 'id', 'item_id');
    }
}
