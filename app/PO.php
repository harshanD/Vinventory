<?php

namespace App;

use App\Http\Controllers\PaymentsController;
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
    protected $appends = ['paid'];

    function getPaidAttribute()
    {
        $payments = new PaymentsController();
        $pending = $payments->refCodeByGetOutstanding($this->referenceCode);
        return $pending;
    }

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
