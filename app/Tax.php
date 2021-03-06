<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Tax extends Model
{
    //
    protected $table='tax_profiles';
    use SoftDeletes;
    use Userstamps;
}
