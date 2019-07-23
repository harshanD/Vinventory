<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BrandsController extends Controller
{
    public function index()
    {

        return view('vendor.adminlte.brands.index');
    }

    public function create(Request $request)
    {
        $request->validate([
            'brand_name' => 'required|unique:brands|max:191',
            'active' => 'required',
        ]);

        print_r($request->input());
    }
}
