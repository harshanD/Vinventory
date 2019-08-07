<?php

namespace App\Http\Controllers;

use App\Locations;
use App\Supplier;
use Illuminate\Http\Request;

class POController extends Controller
{
    public function index()
    {
        $locations = Locations::where('status', \Config::get('constants.status.Active'))->get();
        $supplier = Supplier::where('status', \Config::get('constants.status.Active'))->get();
        return view('vendor.adminlte.po.create', ['locations' => $locations, 'suppliers' => $supplier]);
    }


}
