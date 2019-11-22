<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Invoice;
use App\Products;
use App\Brands;
use App\Stock;
use App\Supplier;
use App\Tax;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class ProductsController extends Controller
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
        if (Permissions::getRolePermissions('createProduct')) {
            $brands = Brands::where('status', \Config::get('constants.status.Active'))->orderBy('brand', 'asc')->get();
            $categories = Categories::where('status', \Config::get('constants.status.Active'))->orderBy('category', 'asc')->get();
            $suppliers = Supplier::where('status', \Config::get('constants.status.Active'))->orderBy('name', 'asc')->get();
            $taxes = Tax::where('status', \Config::get('constants.status.Active'))->orderBy('name', 'asc')->get();

            return view('vendor.adminlte.products.create', ['brands' => $brands, 'categories' => $categories, 'suppliers' => $suppliers, 'taxes' => $taxes]);
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function create(Request $request)
    {
        if (!Permissions::getRolePermissions('createProduct')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'product_name' => 'required|unique:products,name|max:100',
            'product_code' => 'required|max:191',
            'sku' => 'required|max:191',
            'weight' => 'required|numeric',
            'brand' => ['required', Rule::notIn(['0'])],
            'category' => ['required', Rule::notIn(['0'])],
            'unit' => ['required', Rule::notIn(['0'])],
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'cost' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'reorder_level' => ($request['reorder_level'] != '') ? 'required|regex:/^\d+(\.\d{1,2})?$/' : '',
            'description' => ($request['description'] != '') ? 'required' : '',
            'supplier' => 'required',
            'status' => 'required',
            'secondary_name' => ($request['secondary_name'] != '') ? 'required|unique:products,short_name' : '',
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
        $product->status = $request->input('status');
        $product->availability = 0;

        $path = "products/default.jpg";
        if ($request->file('product_image') != null) {
            $path = $request->file('product_image')->store('products');
        }
        $product->img_url = $path;
        $product->save();

        foreach ($request['supplier'] as $supplierid) {
            $product->supplier()->attach(Supplier::where('id', $supplierid)->get());
        }
        if (!$product) {
            return redirect()->back()->with('error', 'Error in the database while creating the brand information');
        } else {
            return redirect()->route('products.manage')->with('message', 'Successfully created');
        }
    }

    public function manageForList()
    {
        if (Permissions::getRolePermissions('viewProduct')) {
            return view('vendor.adminlte.products.index');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }


    public function fetchProductsData()
    {
        $query = Products::select(['id', 'item_code', 'img_url', 'name', 'category', 'unit', 'reorder_level', 'brand', 'selling_price', 'cost_price', 'status']);

        return Datatables::of($query)
            ->addColumn('category', function ($query) {
                return str_limit($query->categories->category, 20);
            })->addColumn('brand', function ($query) {
                return str_limit($query->brands->brand, 20);
            })->addColumn('selling_price', function ($query) {
                return number_format($query->selling_price, 2);
            })->addColumn('cost_price', function ($query) {
                return number_format($query->cost_price, 2);
            })->addColumn('status', function ($query) {
                return ($query->status == \Config::get('constants.status.Active')) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';
            })->addColumn('qty', function ($query) {
                $stockController = new StockController();
                return $stockController->itemQtySumNoteDeletedWareHouses($query->id);
            })->addColumn('unitName', function ($query) {
                return \Config::get('constants.unit_put.' . $query->unit);
            })->addColumn('image', function ($query) {
                return '<a href="' . asset('storage/' . $query->img_url) . '"  class="image-link-custom"><img src="' . asset('storage/' . $query->img_url) . '" style="width:50px;height:50px"  alt="placeholder avatar"></a>';
            })->addColumn('action', function ($query) {
                $buttons = '';

                if (Permissions::getRolePermissions('updateProduct')) {
                    $buttons .= '<a  href="' . url("/products/edit/" . $query->id) . '" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
                }

                if (Permissions::getRolePermissions('deleteProduct')) {
                    $buttons .= '<button type="button" class="btn btn-default" onclick="removeProduct(' . $query->id . ')" data-toggle="modal" data-target="#removeProductModal"><i class="fa fa-trash"></i></button>';
                }
                return $buttons;
            })
            ->removeColumn('billers')->removeColumn('customers')
//            ->editColumn('biller', '{!! str_limit($biller, 3) !!}')
            ->make(true);
    }

    public function editView($id)
    {
        if (Permissions::getRolePermissions('updateProduct')) {
            $brands = Brands::where('status', \Config::get('constants.status.Active'))->orderBy('brand', 'asc')->get();
            $categories = Categories::where('status', \Config::get('constants.status.Active'))->orderBy('category', 'asc')->get();
            $suppliers = Supplier::where('status', \Config::get('constants.status.Active'))->orderBy('name', 'asc')->get();
            $taxes = Tax::where('status', \Config::get('constants.status.Active'))->orderBy('name', 'asc')->get();
            $product = Products::find($id);


            return view('vendor.adminlte.products.edit', ['product' => $product, 'brands' => $brands, 'categories' => $categories, 'suppliers' => $suppliers, 'taxes' => $taxes]);

        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function fetchProductDataById(Request $request)
    {
        $data = (object)Products::where(['id' => $request['id'], 'status' => \Config::get('constants.status.Active')])->get();
        echo json_encode(array(
            'barcode' => $data[0]->barcode,
            'sku' => $data[0]->sku,
            'item_code' => $data[0]->item_code,
            'name' => $data[0]->name,
            'short_name' => $data[0]->short_name,
            'description' => $data[0]->description,
            'img_url' => $data[0]->img_url,
            'selling_price' => $data[0]->selling_price,
            'cost_price' => $data[0]->cost_price,
            'weight' => $data[0]->weight,
            'unit' => $data[0]->unit,
            'availability' => $data[0]->availability,
            'reorder_level' => $data[0]->reorder_level,
            'reorder_activation' => $data[0]->reorder_activation,
            'categoryID' => $data[0]->category,
            'category' => $data[0]->categories->category,
            'brandID' => $data[0]->brand,
            'brand' => $data[0]->brands->brand,
            'tax' => $data[0]->tax,
        ));

    }

    public function editProductData(Request $request)
    {
        $id = $request['id'];
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|unique:products,name,' . $id . '|max:100',
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
            'status' => 'required',
            'secondary_name' => ($request['secondary_name'] != '') ? 'required|unique:products,short_name,' . $id . '' : '',
        ]);


        $niceNames = array(//            'product_name' => 'Products',
        );

        $validator->setAttributeNames($niceNames);
        $validator->validate();

        $product = Products::find($id);

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
        $product->status = $request->input('status');
        $product->availability = 0;

        if ($request->file('product_image') != null) {
            $path = $request->file('product_image')->store('products');
            $product->img_url = $path;
        }


        $product->supplier()->sync($request['supplier']);

        if (!$product->save()) {
            return redirect()->back()->with('error', 'Error in the database while updating the brand information');
        } else {
            return redirect()->route('products.manage')->with('message', 'Successfully Updated');
        }
    }

    public function removeProductData(Request $request)
    {

        $product = Products::find($request->input('id'));

        if (!$product->delete()) {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while removing the product information';
        } else {
            $response['success'] = true;
            $response['messages'] = 'Successfully Removed';
        }
        echo json_encode($response);
    }

    public function fetchProductsList($id)
    {
//        echo $id;
        $supplier = Supplier::find($id);
        $products = $supplier->products;

        $list = array();
        foreach ($products as $key => $product) {
            if ($product->status == \Config::get('constants.status.Active')) {
                $list[$key] = array(
                    'id' => $product->id,
                    'name' => $product->name,
                    'short_name' => $product->short_name,
                    'item_code' => $product->item_code,
                    'description' => $product->description,
                    'img_url' => $product->img_url,
                    'img_url' => $product->img_url,
                    'selling_price' => $product->selling_price,
                    'cost_price' => $product->cost_price,
                    'weight' => $product->weight,
                    'unit' => $product->unit,
                    'reorder_level' => $product->reorder_level,
                    'discount' => 0,
                    'reorder_activation' => $product->reorder_activation,
                    'tax' => (\Config::get('constants.taxActive.Active') == $product->tax_method && $product->tax != 0) ? Tax::find($product->tax)->get()->toArray()[0]['value'] : 0,
                );

            }
        }

        echo json_encode($list);
    }

    public function itemList()
    {
        $data = (object)Products::where(['status' => \Config::get('constants.status.Active')])->get();
        $list = array();
        foreach ($data as $key => $product) {
            $list[$key] = array(
                'id' => $product->id,
                'name' => $product->name,
                'short_name' => $product->short_name,
                'item_code' => $product->item_code,
                'description' => $product->description,
                'img_url' => $product->img_url,
                'img_url' => $product->img_url,
                'selling_price' => $product->selling_price,
                'cost_price' => $product->cost_price,
                'weight' => $product->weight,
                'unit' => $product->unit,
                'reorder_level' => $product->reorder_level,
                'discount' => 0,
                'reorder_activation' => $product->reorder_activation,
                'tax' => (\Config::get('constants.taxActive.Active') == $product->tax_method && $product->tax != 0) ? Tax::find($product->tax)->get()->toArray()[0]['value'] : 0,
            );
        }

        echo json_encode($list);
    }


}
