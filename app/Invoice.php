<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Invoice extends Model
{
    //
    use SoftDeletes;
    use Userstamps;
    protected $table = 'invoice';

    function invoiceItems()
    {
        return $this->hasMany(InvoiceDetails::class, 'invoice_id', 'id');
    }

    function products()
    {
        return $this->hasManyThrough(Products::class, InvoiceDetails::class, 'invoice_id', 'id');
    }

    function locations()
    {
        return $this->hasOne(Locations::class, 'id', 'location');
    }

    function billers()
    {
        return $this->hasOne(Biller::class, 'id', 'biller');
    }

    function customers()
    {
        return $this->hasOne(Customer::class, 'id', 'customer');
    }
}
