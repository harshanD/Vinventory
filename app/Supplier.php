<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    //
    protected $table ="Supplier";
    use SoftDeletes;

    public function products()
    {
        return $this->belongsToMany(Products::class);
    }
}
