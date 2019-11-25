<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetails extends Model
{
    protected $table = 'invoice_details';
    protected $fillable = ['selling_price', 'qty', 'tax_val', 'tax_per', 'discount', 'sub_total', 'invoice_id', 'item_id', 'id', 'created_at', 'created_at'];

    function products()
    {
        return $this->hasOne(Products::class, 'id', 'item_id');
    }


}
