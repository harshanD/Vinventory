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
    protected $fillable = array('cost_price', 'qty', 'tax_val', 'received_qty',
        'discount', 'sub_total', 'tax_percentage', 'updated_at', 'created_at', 'item_id', 'po_header');


    function poHeader()
    {
        return $this->hasOne(PoDetails::class, 'po_header');
    }

    public function product()
    {
        return $this->hasOne(Products::class, 'id', 'item_id');
    }
}
