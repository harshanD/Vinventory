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
        return $this->belongsTo(PO::class, 'parent_reference_code', 'referenceCode');
    }

    public function invoices()
    {
        return $this->belongsTo(Invoice::class, 'parent_reference_code', 'invoice_code');
    }

}
