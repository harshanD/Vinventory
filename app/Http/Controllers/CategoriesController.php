<?php

namespace App\Http\Controllers;

use App\Categories;
use App\User;
use Illuminate\Http\Request;

class CategoriesController extends Controller
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

        return view('vendor.adminlte.categories.index');
    }

    public function create(Request $request)
    {
        $request->validate([
            'category' => 'required|unique:categories|max:191',
            'status' => 'required',
        ]);

        $categories = new Categories();
        $categories->category = $request->input('category');
        $categories->code = $request->input('code');
        $categories->description = $request->input('description');
        $categories->status = $request->input('status');

        if (!$categories->save()) {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while creating the category information';
        } else {
            $response['success'] = true;
            $response['messages'] = 'Successfully created';
        }
        echo json_encode($response);
    }

    public function fetchCategoryData()
    {
        $result = array('data' => array());

//        $data = Categories::where('status', \Config::get('constants.status.Active'))->orderBy('category', 'asc')->get();
        $data = Categories::orderBy('category', 'asc')->get();

        foreach ($data as $key => $value) {
            // button
            $buttons = '';

            if (Permissions::getRolePermissions('viewCategory')) {
                $buttons .= '<button type="button" class="btn btn-default" onclick="editCategory(' . $value->id . ')" data-toggle="modal" data-target="#editCategoryModal"><i class="fa fa-pencil"></i></button>';
            }

            if (Permissions::getRolePermissions('deleteCategory')) {
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeCategory(' . $value->id . ')" data-toggle="modal" data-target="#removeCategoryModal"><i class="fa fa-trash"></i></button>';
            }

            $status = ($value->status == \Config::get('constants.status.Active')) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

            $result['data'][$key] = array(
                $value->code,
                $value->category,
                $status,
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }

    public function fetchCategoryDataById($id)
    {
        $data = (Object)Categories::find($id)->toArray();
        echo json_encode(array('name' => $data->category, 'description' => $data->description, 'code' => $data->code, 'status' => $data->status));

    }

    public function editCategoryData(Request $request, $id)
    {
        $request->validate([
            'edit_category_name' => 'required|unique:categories,category,'.$id.'|max:191',
            'edit_status' => 'required',
        ]);

        $category = Categories::find($id);

        $category->category = $request->input('edit_category_name');
        $category->code = $request->input('edit_code');
        $category->description = $request->input('edit_description');
        $category->status = $request->input('edit_status');

        if (!$category->save()) {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while updating the category information';
        } else {
            $response['success'] = true;
            $response['messages'] = 'Successfully Updated';
        }
        echo json_encode($response);
    }

    public function removeCategoryData(Request $request)
    {

        $category = Categories::find($request->input('category_id'));

        if (!$category->delete()) {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while removing the category information';
        } else {
            $response['success'] = true;
            $response['messages'] = 'Successfully Removed';
        }
        echo json_encode($response);
    }
}
