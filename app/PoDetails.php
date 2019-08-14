<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PoDetails extends Model
{
    //
    use SoftDeletes;
    public $timestamps = true;
    protected $table = 'po_details';

    function poHeader()
    {
        return $this->hasOne(poDetails::class, 'po_header');
    }
}
