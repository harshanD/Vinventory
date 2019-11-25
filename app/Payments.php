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
        return $this->belongsTo(PO::class, 'referenceCode', 'parent_reference_code');
    }

    public function invoices()
    {
        return $this->belongsTo(Invoice::class, 'parent_reference_code', 'invoice_code');
    }

    public function poAndInvoices()
    {
        $strg = substr($this->parent_reference_code, 0, 2);

        $po = new PO();
        $invo = new Invoice();

        switch ($strg):
            case 'PO':

                break;
            case 'IV':
                break;
        endswitch;


    }
}
