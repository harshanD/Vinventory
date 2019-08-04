<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brands extends Model
{
    //
//    protected $primaryKey ='id';
    protected $fillable = ['brand'];
    use SoftDeletes;

    public function products()
    {
        return $this->belongsTo(Products::class);
    }
}
