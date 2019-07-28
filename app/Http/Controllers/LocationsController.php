<?php

namespace App\Http\Controllers;

use App\Locations;
use App\User;
use Illuminate\Http\Request;

class LocationsController extends Controller
{
    public function index(User $user)
    {
//        Auth::user()->hasRole('Admin'); // individually check role has accessibility
//        Auth::user()->hasAnyRole(['Admin', 'Employer']); // check for roles accessibility using array
//        Auth::user()->authorizeRoles('Admin'); // if unauthorized then show error window
//        print_r(Permissions::getRolePermissions('createUser')); check User permission

        return view('vendor.adminlte.locations.index');
    }

    public function create(Request $request)
    {
        $request->validate([
            'location' => 'required|unique:locations,name|max:191',
            'status' => 'required',
        ]);

        $locations = new Locations();
        $locations->name = $request->input('location');
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

            if (Permissions::getRolePermissions('viewLocation')) {
                $buttons .= '<button type="button" class="btn btn-default" onclick="editLocation(' . $value->id . ')" data-toggle="modal" data-target="#editLocationModal"><i class="fa fa-pencil"></i></button>';
            }

            if (Permissions::getRolePermissions('deleteLocation')) {
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeLocation(' . $value->id . ')" data-toggle="modal" data-target="#removeLocationModal"><i class="fa fa-trash"></i></button>';
            }

            $status = ($value->status == \Config::get('constants.status.Active')) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

            $result['data'][$key] = array(
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
        echo json_encode(array('name' => $data->location, 'status' => $data->status));

    }

    public function editLocationData(Request $request, $id)
    {
        $request->validate([
            'edit_location_name' => 'required|unique:locations,location|max:191',
            'edit_status' => 'required',
        ]);

        $location = Locations::find($id);

        $location->name = $request->input('edit_location_name');
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
