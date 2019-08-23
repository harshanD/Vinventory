<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Transfers extends Model
{
    protected $table = 'transfers';
    use SoftDeletes;
    use Userstamps;


    public function fromLocation()
    {
        return $this->hasOne(Locations::class, 'id', 'from_location');
    }

    public function toLocation()
    {
        return $this->hasOne(Locations::class, 'id', 'to_location');
    }

}
