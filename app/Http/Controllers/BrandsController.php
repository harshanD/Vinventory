<?php

namespace App\Http\Controllers;

use App\Brands;
use App\User;
//use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\Flysystem\Config;
use PhpParser\Node\Expr\Cast\Object_;

//use App\Http\Controllers\Permissions;

class BrandsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth' => 'verified']);
    }


    public function index(User $user)
    {
//        Auth::user()->hasRole('Admin'); // individually check role has accessibility
//        Auth::user()->hasAnyRole(['Admin', 'Employer']); // check for roles accessibility using array
//        Auth::user()->authorizeRoles('Admin'); // if unauthorized then show error window
//        var_dump(Permissions::getRolePermissions('createUser')); /*check User permission*/
        if (!Permissions::getRolePermissions('viewBrand')) {
            abort(403, 'Unauthorized action.');
        }
        return view('vendor.adminlte.brands.index');
    }

    public function create(Request $request)
    {
        if (!Permissions::getRolePermissions('createBrand')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'brand' => 'required|unique:brands|max:191',
            'status' => 'required',
        ]);

        $brands = new Brands();
        $brands->brand = $request->input('brand');
        $brands->code = $request->input('code');
        $brands->description = $request->input('description');
        $brands->status = $request->input('status');

        if (!$brands->save()) {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while creating the brand information';
        } else {
            $response['success'] = true;
            $response['messages'] = 'Successfully created';
        }
        echo json_encode($response);
    }

    public function fetchBrandData()
    {
        $result = array('data' => array());

//        $data = Brands::where('status', \Config::get('constants.status.Active'))->orderBy('brand', 'asc')->get();
        $data = Brands::orderBy('brand', 'asc')->get();

        foreach ($data as $key => $value) {
            // button
            $buttons = '';

            if (Permissions::getRolePermissions('viewBrand')) {
                $buttons .= '<button type="button" class="btn btn-default" onclick="editBrand(' . $value->id . ')" data-toggle="modal" data-target="#editBrandModal"><i class="fa fa-pencil"></i></button>';
            }

            if (Permissions::getRolePermissions('deleteBrand')) {
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeBrand(' . $value->id . ')" data-toggle="modal" data-target="#removeBrandModal"><i class="fa fa-trash"></i></button>';
            }

            $status = ($value->status == \Config::get('constants.status.Active')) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

            $result['data'][$key] = array(
                $value->code,
                $value->brand,
                $status,
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }

    public function fetchBrandDataById($id)
    {
        $data = (Object)Brands::find($id)->toArray();
        echo json_encode(array('name' => $data->brand,'code' => $data->code,'description' => $data->description, 'status' => $data->status));

    }

    public function editBrandData(Request $request, $id)
    {
        if (!Permissions::getRolePermissions('updateBrand')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'edit_brand_name' => 'required|unique:brands,brand,'.$id.'|max:191',
            'edit_status' => 'required',
        ]);

        $brand = Brands::find($id);

        $brand->brand = $request->input('edit_brand_name');
        $brand->code = $request->input('edit_code');
        $brand->description = $request->input('edit_description');
        $brand->status = $request->input('edit_status');

        if (!$brand->save()) {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while updating the brand information';
        } else {
            $response['success'] = true;
            $response['messages'] = 'Successfully Updated';
        }
        echo json_encode($response);
    }

    public function removeBrandData(Request $request)
    {
        if (!Permissions::getRolePermissions('deleteBrand')) {
            abort(403, 'Unauthorized action.');
        }
        $brand = Brands::find($request->input('brand_id'));

        if (!$brand->delete()) {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while removing the brand information';
        } else {
            $response['success'] = true;
            $response['messages'] = 'Successfully Removed';
        }
        echo json_encode($response);
    }
}
