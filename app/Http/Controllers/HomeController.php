<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
        return view('home');
    }

    public function registerUserView()
    {
        $data = Role::orderBy('name', 'asc')->get();
        return view('vendor.adminlte.users.create', ['roles' => $data]);
    }

    public function registerUser(Request $request, Role $role)
    {

        $validator = Validator::make($request->all(), [
            'role' => ['required', Rule::notIn(['0'])],
            'email' => 'required|email|unique:users',
            'password' => 'required:min:6',
            'cpassword' => 'required|same:password',
            'fname' => 'required|max:100|regex:/^[\pL\s\-]+$/u',
            'phone' => 'required|between:10,12',
            'gender' => 'required',
        ]);

        $niceNames = array(
            'cpassword' => 'confirm password',
            'fname' => 'first name',
            'lname' => 'last name',
            'email' => 'email address',
        );

        $validator->setAttributeNames($niceNames);
        if (!$validator->validate()) {
            return redirect()->back()->withInput();
        }
        $avatar = "/img/avatar.png";
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

    public function setAttributeNames(array $attributes)
    {
        $this->customAttributes = $attributes;

        return $this;
    }

    public function userList()
    {
        return view('vendor.adminlte.users.index');
    }

    public function fetchUsersData()
    {
        if (Permissions::getRolePermissions('viewUserList')) {
            $users = User::with('roles')->get();
        } else {
            $users = User::with('roles')
                ->where('users.id', Auth::id())
                ->get();
        }

        $result = array('data' => array());


        foreach ($users as $key => $value) {
            // button
            $buttons = '';

            if (Permissions::getRolePermissions('updateUser')) {
                $buttons .= '<button type="button" class="btn btn-default" onclick="editUser(' . $value->id . ')" data-toggle="modal" data-target="#editBrandModal"><i class="fa fa-pencil"></i></button>';
            }

            if (Permissions::getRolePermissions('deleteUser')) {
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeUser(' . $value->id . ')" data-toggle="modal" data-target="#removeBrandModal"><i class="fa fa-trash"></i></button>';
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

}
