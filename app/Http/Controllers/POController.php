<?php

namespace App\Http\Controllers;

use App\Locations;
use App\Supplier;
use App\Tax;
use App\PO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class POController extends Controller
{
    public function index()
    {
        $locations = Locations::where('status', \Config::get('constants.status.Active'))->get();
        $supplier = Supplier::where('status', \Config::get('constants.status.Active'))->get();
        $tax = Tax::where('status', \Config::get('constants.status.Active'))->get();
        return view('vendor.adminlte.po.create', ['locations' => $locations, 'suppliers' => $supplier, 'tax' => $tax]);
    }

    public function create(Request $request)
    {
        print_r($request->input());
        return 'sss';
        $request->validate([
            'po' => 'required|unique:po_profiles,name|max:100',
            'poRate' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        $po = new PO();
        $po->name = $request->input('po');
        $po->code = $request->input('code');
        $po->type = $request->input('type');
        $po->value = $request->input('poRate');
        $po->status = \Config::get('constants.status.Active');

        if (!$po->save()) {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while creating the po information';
        } else {
            $response['success'] = true;
            $response['messages'] = 'Successfully created';
        }
        echo json_encode($response);
    }

    public function fetchPOData()
    {
        $result = array('data' => array());

//        $data = PO::where('status', \Config::get('constants.status.Active'))->orderBy('po', 'asc')->get();
        $data = PO::orderBy('name', 'asc')->get();

        foreach ($data as $key => $value) {
            // button
            $buttons = '';

//            if (Permissions::getRolePermissions('viewPO')) {
            $buttons .= '<button type="button" class="btn btn-default" onclick="editPO(' . $value->id . ')" data-toggle="modal" data-target="#editPOModal"><i class="fa fa-pencil"></i></button>';
//            }

//            if (Permissions::getRolePermissions('deletePO')) {
            $buttons .= ' <button type="button" class="btn btn-default" onclick="removePO(' . $value->id . ')" data-toggle="modal" data-target="#removePOModal"><i class="fa fa-trash"></i></button>';
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

    public function fetchPODataById($id)
    {
        $data = (Object)PO::find($id)->toArray();

        echo json_encode(array('name' => $data->name, 'code' => $data->code, 'value' => $data->value,
            'type' => $data->type, 'status' => $data->status));

    }

    public function editPOData(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'edit_po' => 'required|unique:po_profiles,name,' . $id . '|max:100',
            'edit_poRate' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        $niceNames = array(
            'edit_po' => 'PO',
            'edit_code' => 'Code',
            'edit_type' => 'Type',
            'edit_poRate' => 'PO Rate',
        );
        $validator->setAttributeNames($niceNames);
        $validator->validate();

        $po = PO::find($id);

        $po->name = $request->input('edit_po');
        $po->code = $request->input('edit_code');
        $po->type = $request->input('edit_type');
        $po->value = $request->input('edit_poRate');
        $po->status = $request->input('edit_status');

        if (!$po->save()) {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while updating the po information';
        } else {
            $response['success'] = true;
            $response['messages'] = 'Successfully Updated';
        }
        echo json_encode($response);
    }

    public function removePOData(Request $request)
    {

        $po = PO::find($request->input('id'));

        if (!$po->delete()) {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while removing the po information';
        } else {
            $response['success'] = true;
            $response['messages'] = 'Successfully Removed';
        }
        echo json_encode($response);
    }
}
