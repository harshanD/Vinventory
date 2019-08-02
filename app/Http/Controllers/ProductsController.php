<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Products;
use App\Brands;
use App\Supplier;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductsController extends Controller
{
    public function index(User $user)
    {
//        Auth::user()->hasRole('Admin'); // individually check role has accessibility
//        Auth::user()->hasAnyRole(['Admin', 'Employer']); // check for roles accessibility using array
//        Auth::user()->authorizeRoles('Admin'); // if unauthorized then show error window
//        print_r(Permissions::getRolePermissions('createUser')); check User permission
        $brands = Brands::where('status', \Config::get('constants.status.Active'))->orderBy('brand', 'asc')->get();
        $categories = Categories::where('status', \Config::get('constants.status.Active'))->orderBy('category', 'asc')->get();
        $suppliers = Supplier::where('status', \Config::get('constants.status.Active'))->orderBy('name', 'asc')->get();

        return view('vendor.adminlte.products.create', ['brands' => $brands, 'categories' => $categories, 'suppliers' => $suppliers]);
    }

    public function create(Request $request)
    {

        $request->validate([
            'product_name' => 'required|unique:products,name|max:100|regex:/(^[A-Za-z0-9 ]+$)+/',
            'product_code' => 'required|max:191',
            'sku' => 'required|max:191',
            'weight' => 'required',
            'brand' => ['required', Rule::notIn(['0'])],
            'category' => ['required', Rule::notIn(['0'])],
            'unit' => ['required', Rule::notIn(['0'])],
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'cost' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'reorder_level' => ($request['reorder_level'] != '') ? 'required|regex:/^\d+(\.\d{1,2})?$/' : '',
            'description' => ($request['description'] != '') ? 'required' : '',
            'supplier' => 'required',
        ]);

        $product = new Products();
        $product->name = $request->input('product_name');
        $product->item_code = $request->input('product_code');
        $product->short_name = $request->input('secondary_name');
        $product->sku = $request->input('sku');
        $product->weight = $request->input('weight');
        $product->brand = $request->input('brand');
        $product->category = $request->input('category');
        $product->unit = $request->input('unit');
        $product->selling_price = $request->input('price');
        $product->cost_price = $request->input('cost');
        $product->reorder_level = ($request->input('reorder_level') != '') ? $request->input('reorder_level') : 0;
        $product->description = ($request->input('description') != '') ? $request->input('description') : '';
        $product->reorder_activation = ($request->input('reorder_activate') != '') ? 0 : '1';
        $product->tax = $request->input('tax');
        $product->tax_method = $request->input('tax_activation');
        $product->availability = 0;

        $path = "/img/default.jpg";
        if ($request->file('product_image') != null) {
            $path = $request->file('product_image')->store('products');
        }
        $product->img_url = $path;
        $product->save();

        $product->supplier()->attach(Supplier::where('id', $request['supplier'])->get());
        if (!$product) {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while creating the product information';
        } else {
            $response['success'] = true;
            $response['messages'] = 'Successfully created';
        }
        echo json_encode($response);
    }

    public function manageForList()
    {
        return view('vendor.adminlte.products.index');
    }
    
    public function fetchProductsData()
    {
        $result = array('data' => array());

//        $data = Products::with('categories')->orderBy('name', 'asc')->get();
        $data = Products::with('categories')->get();
//        brands
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        foreach ($data as $key => $value) {
            // button
            $buttons = '';

//            if (Permissions::getRolePermissions('viewProduct')) {
            $buttons .= '<button type="button" class="btn btn-default" onclick="editProduct(' . $value->id . ')" data-toggle="modal" data-target="#editProductModal"><i class="fa fa-pencil"></i></button>';
//            }

//            if (Permissions::getRolePermissions('deleteProduct')) {
            $buttons .= ' <button type="button" class="btn btn-default" onclick="removeProduct(' . $value->id . ')" data-toggle="modal" data-target="#removeProductModal"><i class="fa fa-trash"></i></button>';
//            }

            $status = ($value->status == \Config::get('constants.status.Active')) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

$url =


            $image = '<img src="'.asset(\Storage::url($value->img_url)).'" style="width:50px;height:50px" class="rounded-circle z-depth-1-half avatar-pic" alt="placeholder avatar">';

            $result['data'][$key] = array(
                $image,
                $value->item_code,
                $value->name,
                $value->brand,
                $value->categories,
                $value->cost_price,
                $value->selling_price,
                $value->availability,
                \Config::get('constants.unit_put.'.$value->unit),
                $value->reorder_level,
                $value->reorder_level,
//                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }

    public function fetchProductDataById($id)
    {
        $data = (Object)Products::find($id)->toArray();

        echo json_encode(array('name' => $data->name, 'address' => $data->address, 'phone' => $data->phone,
            'company' => $data->company, 'address' => $data->address, 'email' => $data->email, 'status' => $data->status));

    }

    public function editProductData(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'edit_product' => 'required|unique:product,name,' . $id . '|max:100',
            'edit_company' => 'required|max:100',
            'edit_address' => 'required|max:200',
            'edit_phone' => 'required|between:10,12',
            'edit_email' => 'required|email|max:100',
        ]);

        $niceNames = array(
            'edit_product' => 'Products',
            'edit_company' => 'Code',
            'edit_address' => 'Address',
            'edit_phone' => 'Phone',
            'edit_email' => 'Email',
        );
        $validator->setAttributeNames($niceNames);
        $validator->validate();

        $product = Products::find($id);

        $product->name = $request->input('edit_product');
        $product->company = $request->input('edit_company');
        $product->address = $request->input('edit_address');
        $product->phone = $request->input('edit_phone');
        $product->email = $request->input('edit_email');
        $product->status = $request->input('edit_status');

        if (!$product->save()) {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while updating the product information';
        } else {
            $response['success'] = true;
            $response['messages'] = 'Successfully Updated';
        }
        echo json_encode($response);
    }

    public function removeProductData(Request $request)
    {

        $product = Products::find($request->input('product_id'));

        if (!$product->delete()) {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while removing the product information';
        } else {
            $response['success'] = true;
            $response['messages'] = 'Successfully Removed';
        }
        echo json_encode($response);
    }
}
