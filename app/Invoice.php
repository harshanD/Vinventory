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
}
