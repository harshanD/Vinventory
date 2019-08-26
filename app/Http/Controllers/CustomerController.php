<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function index()
    {
        return view('vendor.adminlte.customer.create');
    }

    public function create(Request $request)
    {
        $request->validate([
            'company' => 'required|max:100|regex:/(^[A-Za-z0-9 ]+$)+/',
            'name' => 'required|max:100|unique:customer,name|regex:/(^[A-Za-z0-9 ]+$)+/',
            'email' => 'required|email|max:191|',
            'phone' => 'required|between:10,12',
            'address' => 'required|max:191|',
        ]);

        $customer = new Customer;
        $customer->company = $request->input('company');
        $customer->name = $request->input('name');
        $customer->email = $request->input('email');
        $customer->phone = $request->input('phone');
        $customer->address = $request->input('address');

        if (!($customer->save())) {
            $request->session()->flash('message', 'Error in the database while creating the Customer');
            $request->session()->flash('message-type', 'error');
        } else {
            $request->session()->flash('message', 'Successfully Created !');
            $request->session()->flash('message-type', 'success');
        }
        return redirect()->route('customer.manage');
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'company' => 'required|max:100|regex:/(^[A-Za-z0-9 ]+$)+/',
            'name' => 'required|max:100|unique:customer,name,' . $id . '|regex:/(^[A-Za-z0-9 ]+$)+/',
            'email' => 'required|email|max:191|',
            'phone' => 'required|between:10,12',
            'address' => 'required|max:191|',
        ]);

//        Customer::createOrUpdate();

        $customer = Customer::find($id);
        $customer->company = $request->input('company');
        $customer->name = $request->input('name');
        $customer->email = $request->input('email');
        $customer->phone = $request->input('phone');
        $customer->address = $request->input('address');


        if (!($customer->save())) {
            $request->session()->flash('message', 'Error in the database while updating the Customer');
            $request->session()->flash('message-type', 'error');
        } else {
            $request->session()->flash('message', 'Successfully Updated !');
            $request->session()->flash('message-type', 'success');
        }
        return redirect()->route('customer.manage');
    }

    public function fetchTransData()
    {
        $result = array('data' => array());

//        $data = Transfers::where('status', \Config::get('constants.status.Active'))->orderBy('transfers', 'asc')->get();
//        $data = Transfers::orderBy('due_date', 'desc')->get();
        $data = Customer::get();

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
                    <li><a href=\"/customer/edit/" . $value->id . "\">Edit Customer</a></li>
                    <li><a href=\"/customer/view/" . $value->id . "\">View Customer</a></li>
                     <li><a href=\"/customer/print/" . $value->id . "\">Download as PDF</a></li>
                    <li class=\"divider\"></li>
                     <li><a onclick=\"deletePo(" . $value->id . ")\">Delete Customer</a></li>
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

    public function cusList()
    {
        return view('vendor.adminlte.customer.index');
    }

    public function editView($id)
    {
        $cus = Customer::find($id)->get()->first();

        return view('vendor.adminlte.customer.edit', ['customer' => $cus]);
    }

}