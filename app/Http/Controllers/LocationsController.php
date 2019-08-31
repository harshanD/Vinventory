<?php

namespace App\Http\Controllers;

use App\Locations;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationsController extends Controller
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
//        print_r(Permissions::getRolePermissions('createUser')); check User permission
        if (!Permissions::getRolePermissions('viewWarehouse')) {
            abort(403, 'Unauthorized action.');
        }
        return view('vendor.adminlte.locations.index');
    }

    public function create(Request $request)
    {
        if (!Permissions::getRolePermissions('createWarehouse')) {
            abort(403, 'Unauthorized action.');
        }
//        print_r($request->all());
//        return 'sdfs';
        $request->validate([
            'location' => 'required|unique:locations,name|max:100',
            'code' => 'required|unique:locations,code|max:100',
            'address' => 'required|max:200',
            'person' => 'required|max:100|regex:/^[\pL\s\-]+$/u',
            'phone' => 'required|between:10,12',
            'email' => 'required|email|max:100',
            'status' => 'required',
        ]);

        $locations = new Locations();
        $locations->name = $request->input('location');
        $locations->code = $request->input('code');
        $locations->address = $request->input('address');
        $locations->contact_person = $request->input('person');
        $locations->telephone = $request->input('phone');
        $locations->type = 1;
        $locations->email = $request->input('email');
        $locations->status = $request->input('status');

        if (!$locations->save()) {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while creating the location information';
        } else {
            $response['success'] = true;
            $response['messages'] = 'Successfully created';
        }
        echo json_encode($response);
    }

    public function fetchLocationData()
    {
        $result = array('data' => array());

//        $data = Locations::where('status', \Config::get('constants.status.Active'))->orderBy('location', 'asc')->get();
        $data = Locations::orderBy('name', 'asc')->get();

        foreach ($data as $key => $value) {
            // button
            $buttons = '';

            if (Permissions::getRolePermissions('viewWarehouse')) {
                $buttons .= '<button type="button" class="btn btn-default" onclick="editLocation(' . $value->id . ')" data-toggle="modal" data-target="#editLocationModal"><i class="fa fa-pencil"></i></button>';
            }

            if (Permissions::getRolePermissions('deleteWarehouse')) {
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeLocation(' . $value->id . ')" data-toggle="modal" data-target="#removeLocationModal"><i class="fa fa-trash"></i></button>';
            }

            $status = ($value->status == \Config::get('constants.status.Active')) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

            $result['data'][$key] = array(
                $value->code,
                $value->name,
                $status,
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }

    public function fetchLocationDataById($id)
    {
        $data = (Object)Locations::find($id)->toArray();

        echo json_encode(array('name' => $data->name, 'address' => $data->address, 'phone' => $data->telephone,
            'code' => $data->code, 'address' => $data->address, 'email' => $data->email, 'person' => $data->contact_person, 'status' => $data->status));

    }

    public function editLocationData(Request $request, $id)
    {
        if (!Permissions::getRolePermissions('updateWarehouse')) {
            abort(403, 'Unauthorized action.');
        }
        $validator = Validator::make($request->all(), [
            'edit_location' => 'required|unique:locations,name,' . $id . '|max:100',
            'edit_code' => 'required|unique:locations,code,' . $id . '|max:100',
            'edit_address' => 'required|max:200',
            'edit_person' => 'required|max:100|regex:/^[\pL\s\-]+$/u',
            'edit_phone' => 'required|between:10,12',
            'edit_email' => 'required|email|max:100',
        ]);

        $niceNames = array(
            'edit_location' => 'Warehouse',
            'edit_code' => 'Code',
            'edit_address' => 'Address',
            'edit_person' => 'Contact Person',
            'edit_phone' => 'Phone',
            'edit_email' => 'Email',
        );
        $validator->setAttributeNames($niceNames);
        $validator->validate();

        $location = Locations::find($id);

        $location->name = $request->input('edit_location');
        $location->code = $request->input('edit_code');
        $location->address = $request->input('edit_address');
        $location->contact_person = $request->input('edit_person');
        $location->telephone = $request->input('edit_phone');
        $location->email = $request->input('edit_email');
        $location->status = $request->input('edit_status');

        if (!$location->save()) {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while updating the location information';
        } else {
            $response['success'] = true;
            $response['messages'] = 'Successfully Updated';
        }
        echo json_encode($response);
    }

    public function removeLocationData(Request $request)
    {
        if (!Permissions::getRolePermissions('deleteWarehouse')) {
            abort(403, 'Unauthorized action.');
        }
        $location = Locations::find($request->input('location_id'));

        if (!$location->delete()) {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while removing the location information';
        } else {
            $response['success'] = true;
            $response['messages'] = 'Successfully Removed';
        }
        echo json_encode($response);
    }
}
