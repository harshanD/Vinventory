<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Supplier extends Model
{
    //
    protected $table ="supplier";
    use SoftDeletes;
    use Userstamps;
//
    public function products()
    {
        return $this->belongsToMany(Products::class);
    }
}
