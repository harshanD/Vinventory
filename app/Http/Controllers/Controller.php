<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public static function replace($matches)
    {
        if (isset($matches[1])) {
            $length = strlen($matches[1]);
            return sprintf("%0" . $length . "d", ++$matches[1]);
        }
    }

    public static function numberFormatRemove($number)
    {
        $number = str_replace(",", "", $number);
        return $number;
    }
}
