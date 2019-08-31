<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Role extends Model
{

    protected $fillable = ['name'];
    use SoftDeletes;
    use Userstamps;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

}
