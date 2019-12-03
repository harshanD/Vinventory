<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Payments extends Model
{
    use SoftDeletes;
    use Userstamps;
    protected $table = 'payments';


    function po()
    {
        return $this->hasOne(PO::class, 'referenceCode', 'parent_reference_code');
    }

    public function invoices()// usable
    {
        return $this->hasOne(Invoice::class, 'invoice_code', 'parent_reference_code');
    }

}
