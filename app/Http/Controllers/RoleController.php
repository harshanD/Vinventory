<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
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

        return view('vendor.adminlte.role.index');
    }

    public function create(Request $request)
    {
//        print_r($request->all());
//        return 'sdfs';
        $request->validate([
            'role_name' => 'required|unique:roles,name|max:100|regex:/^[\pL\s\-]+$/u',
        ]);

        $role = new Role();
        $role->name = $request->input('role_name');
        $role->permissions = serialize($request->input('permission'));
        $role->status = $request->input('status');

        if (!$role->save()) {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while creating the role information';
        } else {
            $response['success'] = true;
            $response['messages'] = 'Successfully created';
        }
        echo json_encode($response);
    }

    public function fetchRoleData()
    {
        $result = array('data' => array());

        $data = Role::orderBy('name', 'asc')->get();

        foreach ($data as $key => $value) {
            // button
            $buttons = '';

            if (Permissions::getRolePermissions('viewRole')) {
            $buttons .= '<button type="button" class="btn btn-default" onclick="editRole(' . $value->id . ')" data-toggle="modal" data-target="#editRoleModal"><i class="fa fa-pencil"></i></button>';
            }

            if (Permissions::getRolePermissions('deleteRole')) {
            $buttons .= ' <button type="button" class="btn btn-default" onclick="removeRole(' . $value->id . ')" data-toggle="modal" data-target="#removeRoleModal"><i class="fa fa-trash"></i></button>';
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

    public function fetchRoleDataById($id)
    {
        $data = (Object)Role::find($id)->toArray();

        echo json_encode(array(
            'name' => $data->name,
            'permission' => unserialize($data->permissions),
            'status' => $data->status));

    }

    public function editRoleData(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'edit_role' => 'required|unique:roles,name,' . $id . '|max:100',
        ]);

        $niceNames = array(
            'edit_role' => 'Role',
        );
        $validator->setAttributeNames($niceNames);
        $validator->validate();

        $role = Role::find($id);

        $role->name = $request->input('edit_role');
        $role->permissions = serialize($request->input('permission'));
        $role->status = $request->input('edit_status');


        if (!$role->save()) {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while updating the role information';
        } else {
            $response['success'] = true;
            $response['messages'] = 'Successfully Updated';
        }
        echo json_encode($response);
    }

    public function removeRoleData(Request $request)
    {

        $role = Role::find($request->input('role_id'));

        if (!$role->delete()) {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while removing the role information';
        } else {
            $response['success'] = true;
            $response['messages'] = 'Successfully Removed';
        }
        echo json_encode($response);
    }
}
