<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Permissions extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth' => 'verified']);
    }

    public static function getRolePermissions($permission = null)
    {
        if (Auth::check() && $permission != null) {
            $permissions = unserialize(\Auth::user()->roles()->get()->toArray()[0]['permissions']);
            if (isset($permissions) && is_array($permissions)) {
                if (in_array($permission, $permissions)) {
                    return true;
                }
            }
            return false;
        }
        return false;
    }
}
