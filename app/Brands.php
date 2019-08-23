<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Brands extends Model
{
    //
//    protected $primaryKey ='id';
    protected $fillable = ['brand'];
    use SoftDeletes;
    use Userstamps;

    public function products()
    {
        return $this->belongsTo(Products::class);
    }
}
