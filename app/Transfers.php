<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfers extends Model
{
    protected $table = 'transfers';
    use SoftDeletes;


}
