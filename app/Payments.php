<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Payments extends Model
{
    use SoftDeletes;
    use Userstamps;
    protected $table = 'payments';
}
