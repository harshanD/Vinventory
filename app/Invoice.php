<?php

namespace App;

use App\Http\Controllers\PaymentsController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Invoice extends Model
{
    //
    use SoftDeletes;
    use Userstamps;
    protected $table = 'invoice';
    protected $appends = ['paid'];

    function getPaidAttribute()
    {
        $payments = new PaymentsController();
        $pending = $payments->refCodeByGetOutstanding($this->invoice_code);
        return $pending;
    }

    function invoiceItems()
    {
        return $this->hasMany(InvoiceDetails::class, 'invoice_id', 'id')->with('products');
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
