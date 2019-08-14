<?php

namespace App\Http\Controllers;

use App\Locations;
use App\Supplier;
use App\Tax;
use App\PO;
use App\PoDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
        $request->validate([
            'datepicker' => 'required|date',
            'status' => ['required', Rule::notIn(['0'])],
            'location' => ['required', Rule::notIn(['0'])],
            'referenceNo' => 'required|unique:po_header,referenceCode',
            'supplier' => ['required', Rule::notIn(['0'])],

        ]);

        $po = new PO();
        $po->due_date = $request->input('datepicker');
        $po->location = $request->input('location');
        $po->referenceCode = $request->input('referenceNo');
        $po->supplier = $request->input('supplier');
        $po->tax = $request->input('wholeTax');
        $po->discount = $request->input('wholeDiscount');
        $po->remark = $request->input('note');
        $po->status = $request->input('status');
        $po->grand_total = $request->input('grand_total');

        $po->save();

        $items = $request->input('item');
        $quantity = $request->input('quantity');
        $costPrice = $request->input('costPrice');
        $p_tax = $request->input('p_tax');
        $unit = $request->input('unit');
        $subtot = $request->input('subtot');
        $discount = $request->input('discount');

        foreach ($items as $id => $item) {

            if ($subtot[$id] > 0) {
                $poItems = new PoDetails();

                $poItems->item_id = $item;
                $poItems->cost_price = $costPrice[$id];
                $poItems->qty = $quantity[$id];
                $poItems->tax_val = $p_tax[$id];
                $poItems->discount = $discount[$id];
                $poItems->sub_total = $subtot[$id];

                $po->poDetails()->save($poItems);
            }

        }


        if (!$po) {
            $request->session()->flash('message', 'Error in the database while creating the PO');
            $request->session()->flash('message-type', 'error');
        } else {
            $request->session()->flash('message', 'Successfully created ' . "[ Ref NO:" . $request->input('referenceNo') . " ]");
            $request->session()->flash('message-type', 'success');
        }
        echo json_encode(array('success' => true));
    }

    public
    function fetchPOData()
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

    public
    function fetchPODataById($id)
    {
        $data = (Object)PO::find($id)->toArray();

        echo json_encode(array('name' => $data->name, 'code' => $data->code, 'value' => $data->value,
            'type' => $data->type, 'status' => $data->status));

    }

    public
    function editPOData(Request $request, $id)
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

    public
    function removePOData(Request $request)
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
