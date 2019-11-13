<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Payments;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\ReportsController;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth' => 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
//        Payments::where('parent_reference_code', $code)->sum('value');
        $invoices = Invoice::with('invoiceItems')->whereMonth('Invoice.invoice_date', '=', 9)->sum('InvoiceDetails.tax_val');
//        $invoices = $this->Invoice()->whereMonth('invoice_date', '=', 9)->sum('invoice_details.tax_val');
        print_r($invoices);
        return 1;
        $report = new ReportsController;
        $sales = $report->last5Sales();
        $purchaces = $report->last5Purcheses();
        $transfers = $report->last5Transfers();
        $customers = $report->last5Customers();
        $suppliers= $report->last5Suppliers();

        $chart = $report->chartData();
        return view('home', [
            'sales' => $sales,
            'purchaces' => $purchaces,
            'transfers' => $transfers,
            'customers' => $customers,
            'suppliers' => $suppliers
        ]);
    }

    public function registerUserView()
    {
        $data = Role::where('status', \Config::get('constants.status.Active'))->orderBy('name', 'asc')->get();
        return view('vendor.adminlte.users.create', ['roles' => $data]);
    }

    public function registerUser(Request $request, Role $role)
    {

        $validator = Validator::make($request->all(), [
            'role' => ['required', Rule::notIn(['0'])],
            'email' => 'required|email|unique:users',
            'password' => 'required:min:6',
            'cpassword' => 'required|same:password',
            'fname' => 'required|min:4|max:100|regex:/^[\pL\s\-]+$/u',
            'phone' => 'required|between:10,12',
            'gender' => 'required',
        ]);

        $niceNames = array(
            'cpassword' => 'confirm password',
            'fname' => 'full name',
            'email' => 'email address',
        );

        $validator->setAttributeNames($niceNames);
        if (!$validator->validate()) {
            return redirect()->back()->withInput();
        }
        $avatar = "/avatars/avatar.png";
        if ($request->file('avatar') != null) {
            $path = $request->file('avatar')->store('avatars');
            $avatar = $path;
        }
        $fields = [
            'name' => $request->input('fname'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('email')),
            'phone' => $request->input('phone'),
            'avatar' => $avatar,
            'status' => \Config::get('constants.status.Active'),
            'gender' => $request->input('gender'),
        ];

        $user = User::create($fields);
        $user->roles()->attach(Role::where('id', $request['role'])->first());

        if ($user) {
            return redirect()->route('users.manage')->with('message', 'Successfully added');
        } else {
            return redirect()->back()->with('message', 'Error in the database while adding the brand information');
        }
    }

    public function editSave(Request $request)
    {
        if (!Permissions::getRolePermissions('updateUser')) {
            return redirect()->route('users.manage')->with('error', 'You haven\'t permission');
        }
        $userId = $request->input('userid');
        $user = User::find($userId);

        $validator = Validator::make($request->all(), [
            'role' => ['required', Rule::notIn(['0'])],
            'email' => 'required|email|unique:users,email,' . $userId,
            'fname' => 'required|min:4|max:100|regex:/^[\pL\s\-]+$/u',
            'phone' => (!empty($request->input('phone'))) ? 'between:10,12' : '',
            'gender' => 'required',
        ]);

//print_r($request->input());
//return 'dd';
        if (($request->input('password')) != '' || ($request->input('new_password')) != '' || ($request->input('password_confirmation')) != '') {
            $this->validate($request, [
                'password' => 'required',
                'new_password' => 'required|min:6',
                'password_confirmation' => 'required|same:new_password|different:password',
            ]);

            if (!Hash::check($request->input('password'), Auth::user()->password)) {
                return redirect()->back()->withInput()->with('error', 'Your Password was Incorrect');
//                return redirect()->back()
//                    ->withErrors('Your Password was Incorrect')
//                    ->withInput();
            }
            $user->password = Hash::make($request['password']);
        }

        $niceNames = array(
            'cpassword' => 'confirm password',
            'fname' => 'full name',
            'email' => 'email address',
        );

        $validator->setAttributeNames($niceNames);
        if (!$validator->validate()) {
            return redirect()->back()->withInput();
        }

        if ($request->file('avatar') != null) {
            $path = $request->file('avatar')->store('avatars');
            $user->avatar = $path;
        }


        $user->name = $request->input('fname');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->gender = $request->input('gender');
        $user->status = $request->input('active');

        $user->save();

        $user->roles()->sync($request->input('role'));

        if ($user) {
            return redirect()->route('users.manage')->with('message', 'Successfully Updated');
        } else {
            return redirect()->back()->with('error', 'Error in the database while updating the brand information');
        }
    }

    public function setAttributeNames(array $attributes)
    {
        $this->customAttributes = $attributes;

        return $this;
    }

    public function userList()
    {
        if (Permissions::getRolePermissions('viewUser')) {
            return view('vendor.adminlte.users.index');
        } else {
            abort(403, 'Unauthorized action.');
        }

    }

    public function profile()
    {
        if (!Permissions::getRolePermissions('viewProfile')) {
            abort(403, 'Unauthorized action.');
        }
        $data = Role::orderBy('name', 'asc')->get();
        $user = User::with('roles')
            ->where('users.id', Auth::id())
            ->get();
        return view('vendor.adminlte.users.edit', ['roles' => $data, 'user' => $user]);
    }

    public function userEditView($id)
    {
        if (!Permissions::getRolePermissions('updateUser')) {
            abort(403, 'Unauthorized action.');
        }
        $data = Role::where('status', \Config::get('constants.status.Active'))->orderBy('name', 'asc')->get();
        $user = User::with('roles')
            ->where('users.id', $id)
            ->get();
        return view('vendor.adminlte.users.edit', ['roles' => $data, 'user' => $user]);
    }

    public function fetchUsersData()
    {

        $users = User::with('roles')->get();


        $result = array('data' => array());


        foreach ($users as $key => $value) {
            // button
            $buttons = '';

            if (Permissions::getRolePermissions('updateUser')) {
                $buttons .= '<a  href="' . url("/user/edit/" . $value->id) . '" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
            }

            if (Permissions::getRolePermissions('deleteUser')) {
                $buttons .= '<button type="button" class="btn btn-default" onclick="removeUser(' . $value->id . ')" data-toggle="modal" data-target="#removeBrandModal"><i class="fa fa-trash"></i></button>';
            }

            $status = ($value->status == \Config::get('constants.status.Active')) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

            $result['data'][$key] = array(
                $value->name,
                $value->email,
                $status,
                ($value->phone == null) ? '--' : $value->phone,
                $value->roles[0]->name,
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }

    public function deleteUser($id, Request $request)
    {
        if (!Permissions::getRolePermissions('deleteUser')) {
            abort(403, 'Unauthorized action.');
        }
        User::find($id)->delete();

        if (count(Mail::failures()) > 0) {
            $request->session()->flash('message', 'User deletion failed');
            $request->session()->flash('message-type', 'error');
            return redirect()->back();
        } else {
            $request->session()->flash('message', 'User Deleted !');
            $request->session()->flash('message-type', 'success');
            return redirect()->route('users.manage');
        }
    }

}
