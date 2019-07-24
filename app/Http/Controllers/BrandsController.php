<?php

namespace App\Http\Controllers;

use App\Brands;
//use App\User;
//use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\Flysystem\Config;
//use App\Http\Controllers\Permissions;

class BrandsController extends Controller
{

    public function index()
    {
echo '<pre>';
        print_r(Permissions::getRolePermissions('createUser'));
        echo '</pre>';
        return view('vendor.adminlte.brands.index');
    }

    public function create(Request $request)
    {
        $request->validate([
            'brand' => 'required|unique:brands|max:191',
            'active' => 'required',
        ]);

        $brands = new Brands();
        $brands->brand = $request->input('brand');
        $brands->save();
//        print_r($request->input());

    }

    public function fetchBrandData()
    {
        $result = array('data' => array());

        $data = Brands::where('status', \Config::get('constants.status.Active'))->orderBy('brand', 'asc')->get();

        foreach ($data as $key => $value) {
            // button
            $buttons = '';

//            if(in_array('viewBrand', $this->permission)) {
            $buttons .= '<button type="button" class="btn btn-default" onclick="editBrand(' . $value->id . ')" data-toggle="modal" data-target="#editBrandModal"><i class="fa fa-pencil"></i></button>';
//            }

//            if(in_array('deleteBrand', $this->permission)) {
            $buttons .= ' <button type="button" class="btn btn-default" onclick="removeBrand(' . $value->id . ')" data-toggle="modal" data-target="#removeBrandModal"><i class="fa fa-trash"></i></button>
				';
//            }

            $status = ($value->status == \Config::get('constants.status.Active')) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

            $result['data'][$key] = array(
                $value->brand,
                $status,
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }
}
