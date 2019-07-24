<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Permissions extends Controller
{

    public static function getRolePermissions($permission = null)
    {
        if (Auth::check() && $permission != null) {
            $permissions = unserialize(\Auth::user()->roles()->get()->toArray()[0]['permissions']);
            if (in_array($permission, $permissions)) {
                return true;
            }
        }
        return false;
    }
}
