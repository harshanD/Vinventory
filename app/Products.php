<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    //
    use SoftDeletes;

    public function supplier()
    {
        return $this->belongsToMany(Supplier::class);
    }

    public function categories()
    {
        return $this->hasOne(Categories::class ,'id','category' );
    }

    public function brands()
    {
        return $this->hasOne(Brands::class,'id','brand');
    }
}
