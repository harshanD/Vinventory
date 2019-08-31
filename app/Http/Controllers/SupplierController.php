<?php

namespace App\Http\Controllers;

use App\Supplier;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
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

        return view('vendor.adminlte.supplier.index');
    }

    public function create(Request $request)
    {
//        print_r($request->all());
//        return 'sdfs';
        $request->validate([
            'supplier' => 'required|unique:supplier,name|max:100|regex:/^[\pL\s\-]+$/u',
            'company' => 'required|max:100',
            'address' => 'required|max:200',
            'phone' => 'required|between:10,12',
            'email' => 'required|email|max:100',
            'status' => 'required',
        ]);

        $supplier = new Supplier();
        $supplier->name = $request->input('supplier');
        $supplier->company = $request->input('company');
        $supplier->address = $request->input('address');
        $supplier->phone = $request->input('phone');
        $supplier->email = $request->input('email');
        $supplier->status = $request->input('status');

        if (!$supplier->save()) {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while creating the supplier information';
        } else {
            $response['success'] = true;
            $response['messages'] = 'Successfully created';
        }
        echo json_encode($response);
    }

    public function fetchSupplierData()
    {
        $result = array('data' => array());

        $data = Supplier::orderBy('name', 'asc')->get();

        foreach ($data as $key => $value) {
            // button
            $buttons = '';

            if (Permissions::getRolePermissions('updateSupplier')) {
                $buttons .= '<button type="button" class="btn btn-default" onclick="editSupplier(' . $value->id . ')" data-toggle="modal" data-target="#editSupplierModal"><i class="fa fa-pencil"></i></button>';
            }

            if (Permissions::getRolePermissions('deleteSupplier')) {
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeSupplier(' . $value->id . ')" data-toggle="modal" data-target="#removeSupplierModal"><i class="fa fa-trash"></i></button>';
            }

            $status = ($value->status == \Config::get('constants.status.Active')) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

            $result['data'][$key] = array(
                $value->company,
                $value->name,
                $status,
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }

    public function fetchSupplierDataById($id)
    {
        $data = (Object)Supplier::find($id)->toArray();

        echo json_encode(array('name' => $data->name, 'address' => $data->address, 'phone' => $data->phone,
            'company' => $data->company, 'address' => $data->address, 'email' => $data->email, 'status' => $data->status));

    }

    public function editSupplierData(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'edit_supplier' => 'required|unique:supplier,name,' . $id . '|max:100',
            'edit_company' => 'required|max:100',
            'edit_address' => 'required|max:200',
            'edit_phone' => 'required|between:10,12',
            'edit_email' => 'required|email|max:100',
        ]);

        $niceNames = array(
            'edit_supplier' => 'Supplier',
            'edit_company' => 'Code',
            'edit_address' => 'Address',
            'edit_phone' => 'Phone',
            'edit_email' => 'Email',
        );
        $validator->setAttributeNames($niceNames);
        $validator->validate();

        $supplier = Supplier::find($id);

        $supplier->name = $request->input('edit_supplier');
        $supplier->company = $request->input('edit_company');
        $supplier->address = $request->input('edit_address');
        $supplier->phone = $request->input('edit_phone');
        $supplier->email = $request->input('edit_email');
        $supplier->status = $request->input('edit_status');

        if (!$supplier->save()) {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while updating the supplier information';
        } else {
            $response['success'] = true;
            $response['messages'] = 'Successfully Updated';
        }
        echo json_encode($response);
    }

    public function removeSupplierData(Request $request)
    {

        $supplier = Supplier::find($request->input('supplier_id'));

        if (!$supplier->delete()) {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while removing the supplier information';
        } else {
            $response['success'] = true;
            $response['messages'] = 'Successfully Removed';
        }
        echo json_encode($response);
    }
}
