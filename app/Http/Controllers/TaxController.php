<?php

namespace App\Http\Controllers;

use App\Tax;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaxController extends Controller
{
    public function index(User $user)
    {
//        Auth::user()->hasRole('Admin'); // individually check role has accessibility
//        Auth::user()->hasAnyRole(['Admin', 'Employer']); // check for roles accessibility using array
//        Auth::user()->authorizeRoles('Admin'); // if unauthorized then show error window
//        print_r(Permissions::getRolePermissions('createUser')); check User permission

        return view('vendor.adminlte.tax.index');
    }

    public function create(Request $request)
    {
        $request->validate([
            'tax' => 'required|unique:tax_profiles,name|max:100',
            'taxRate' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        $tax = new Tax();
        $tax->name = $request->input('tax');
        $tax->code = $request->input('code');
        $tax->type = $request->input('type');
        $tax->value = $request->input('taxRate');
        $tax->status = \Config::get('constants.status.Active');

        if (!$tax->save()) {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while creating the tax information';
        } else {
            $response['success'] = true;
            $response['messages'] = 'Successfully created';
        }
        echo json_encode($response);
    }

    public function fetchTaxData()
    {
        $result = array('data' => array());

//        $data = Tax::where('status', \Config::get('constants.status.Active'))->orderBy('tax', 'asc')->get();
        $data = Tax::orderBy('name', 'asc')->get();

        foreach ($data as $key => $value) {
            // button
            $buttons = '';

//            if (Permissions::getRolePermissions('viewTax')) {
            $buttons .= '<button type="button" class="btn btn-default" onclick="editTax(' . $value->id . ')" data-toggle="modal" data-target="#editTaxModal"><i class="fa fa-pencil"></i></button>';
//            }

//            if (Permissions::getRolePermissions('deleteTax')) {
            $buttons .= ' <button type="button" class="btn btn-default" onclick="removeTax(' . $value->id . ')" data-toggle="modal" data-target="#removeTaxModal"><i class="fa fa-trash"></i></button>';
//            }

            $status = ($value->status == \Config::get('constants.status.Active')) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

            $result['data'][$key] = array(
                $value->name,
                $value->code,
                $value->value,
                $value->type,
                $status,
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }

    public function fetchTaxDataById($id)
    {
        $data = (Object)Tax::find($id)->toArray();

        echo json_encode(array('name' => $data->name, 'code' => $data->code, 'value' => $data->value,
            'type' => $data->type, 'status' => $data->status));

    }

    public function editTaxData(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'edit_tax' => 'required|unique:tax_profiles,name,'.$id.'|max:100',
            'edit_taxRate' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        $niceNames = array(
            'edit_tax' => 'Tax',
            'edit_code' => 'Code',
            'edit_type' => 'Type',
            'edit_taxRate' => 'Tax Rate',
        );
        $validator->setAttributeNames($niceNames);
        $validator->validate();

        $tax = Tax::find($id);

        $tax->name = $request->input('edit_tax');
        $tax->code = $request->input('edit_code');
        $tax->type = $request->input('edit_type');
        $tax->value = $request->input('edit_taxRate');
        $tax->status = $request->input('edit_status');

        if (!$tax->save()) {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while updating the tax information';
        } else {
            $response['success'] = true;
            $response['messages'] = 'Successfully Updated';
        }
        echo json_encode($response);
    }

    public function removeTaxData(Request $request)
    {

        $tax = Tax::find($request->input('location_id'));

        if (!$tax->delete()) {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while removing the tax information';
        } else {
            $response['success'] = true;
            $response['messages'] = 'Successfully Removed';
        }
        echo json_encode($response);
    }
}
