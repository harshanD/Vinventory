<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model
{
    //
    protected $fillable = ['brand', 'code', 'description'];
    use SoftDeletes;

    public function products()
    {
        return $this->belongsTo(Products::class);
    }
}
