<?php

namespace App\Http\Controllers;

use App\Biller;
use Illuminate\Http\Request;

class BillerController extends Controller
{
    public function index()
    {
        return view('vendor.adminlte.biller.create');
    }

    public function create(Request $request)
    {
        $request->validate([
            'company' => 'required|max:100|regex:/(^[A-Za-z0-9 ]+$)+/',
            'name' => 'required|max:100|unique:biller,name|regex:/(^[A-Za-z0-9 ]+$)+/',
            'email' => 'required|email|max:191|',
            'phone' => 'required|between:10,12',
            'address' => 'required|max:191|',
        ]);

        $customer = new Biller;
        $customer->company = $request->input('company');
        $customer->name = $request->input('name');
        $customer->email = $request->input('email');
        $customer->phone = $request->input('phone');
        $customer->address = $request->input('address');
        $customer->invoice_footer = $request->input('invoFooter');

        if (!($customer->save())) {
            $request->session()->flash('message', 'Error in the database while creating the Biller');
            $request->session()->flash('message-type', 'error');
        } else {
            $request->session()->flash('message', 'Successfully Created !');
            $request->session()->flash('message-type', 'success');
        }
        return redirect()->route('biller.manage');
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'company' => 'required|max:100|regex:/(^[A-Za-z0-9 ]+$)+/',
            'name' => 'required|max:100|unique:biller,name,' . $id . '|regex:/(^[A-Za-z0-9 ]+$)+/',
            'email' => 'required|email|max:191|',
            'phone' => 'required|between:10,12',
            'address' => 'required|max:191|',
        ]);

//        Biller::createOrUpdate();

        $customer = Biller::find($id);
        $customer->company = $request->input('company');
        $customer->name = $request->input('name');
        $customer->email = $request->input('email');
        $customer->phone = $request->input('phone');
        $customer->address = $request->input('address');
        $customer->invoice_footer = $request->input('invoFooter');


        if (!($customer->save())) {
            $request->session()->flash('message', 'Error in the database while updating the Biller');
            $request->session()->flash('message-type', 'error');
        } else {
            $request->session()->flash('message', 'Successfully Updated !');
            $request->session()->flash('message-type', 'success');
        }
        return redirect()->route('biller.manage');
    }

    public function fetchTransData()
    {
        $result = array('data' => array());

//        $data = Transfers::where('status', \Config::get('constants.status.Active'))->orderBy('transfers', 'asc')->get();
//        $data = Transfers::orderBy('due_date', 'desc')->get();
        $data = Biller::get();

        foreach ($data as $key => $value) {
            // button
            $buttons = '';

//            if (Permissions::getRolePermissions('vi   ewPO')) {
            $buttons .= '<button type="button" class="btn btn-default" onclick="editPO(' . $value->id . ')" data-toggle="modal" data-target="#editPOModal"><i class="fa fa-pencil"></i></button>';
//            }

//            if (Permissions::getRolePermissions('deletePO')) {
            $buttons .= ' <button type="button" class="btn btn-default" onclick="removePO(' . $value->id . ')" data-toggle="modal" data-target="#removePOModal"><i class="fa fa-trash"></i></button>';
//            }


            $buttons = "<div class=\"btn-group\">
                  <button type=\"button\" class=\"btn btn-default btn-flat\">Action</button>
                  <button type=\"button\" class=\"btn btn-default btn-flat dropdown-toggle\" data-toggle=\"dropdown\">
                    <span class=\"caret\"></span>
                    <span class=\"sr-only\">Toggle Dropdown</span>
                  </button>
                  <ul class=\"dropdown-menu\" role=\"menu\">
                    <li><a href=\"/biller/edit/" . $value->id . "\">Edit Biller</a></li>
                    <li><a href=\"/biller/view/" . $value->id . "\">View Biller</a></li>
                     <li><a href=\"/biller/print/" . $value->id . "\">Download as PDF</a></li>
                    <li class=\"divider\"></li>
                     <li><a onclick=\"deletePo(" . $value->id . ")\">Delete Biller</a></li>
                  </ul>
                </div>";

            switch ($value->status):
                case 0:
                    $status = '<span class="label label-success">Active</span>';
                    break;
                case 1:
                    $status = '<span class="label label-success">Inactive</span>';
                    break;
                default:
                    $status = '<span class="label label-warning">Nothing</span>';
                    break;
            endswitch;

            $result['data'][$key] = array(
                $value->company,
                $value->name,
                $value->email,
                $value->phone,
                $status,
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }

    public function billerList()
    {
        return view('vendor.adminlte.biller.index');
    }

    public function editView($id)
    {
        $cus = Biller::find($id)->get()->first();

        return view('vendor.adminlte.biller.edit', ['biller' => $cus]);
    }
}