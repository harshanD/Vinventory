<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Categories extends Model
{
    //
    protected $fillable = ['brand', 'code', 'description'];
    use SoftDeletes;
    use Userstamps;

    public function products()
    {
        return $this->belongsTo(Products::class,'category_id');
    }
}
