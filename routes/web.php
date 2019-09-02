<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
})->middleware('verified');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes(['verify' => true]);

Route::get('/user/register', 'HomeController@registerUserView');
Route::post('user/create', 'HomeController@registerUser');


Route::get('/user/manage', ['as' => 'users.manage', 'uses' => 'HomeController@userList']);
Route::get('/user/fetchUsersData', 'HomeController@fetchUsersData');
Route::get('/user/edit/{id}', 'HomeController@userEditView');
Route::get('/user/profile', 'HomeController@profile');
Route::post('user/editSave', 'HomeController@editSave');
Route::post('/user/delete/{id}', 'HomeController@deleteUser');

/*Brands*/
Route::get('/brands', 'BrandsController@index');
Route::get('/brands/fetchBrandData', 'BrandsController@fetchBrandData');
Route::post('/brands/fetchBrandDataById/{id}', 'BrandsController@fetchBrandDataById');
Route::post('/brands/edit/{id}', 'BrandsController@editBrandData');
Route::post('/brands/remove', 'BrandsController@removeBrandData');
Route::post('/brands/create', 'BrandsController@create');

/*Categories*/
Route::get('/categories', 'CategoriesController@index');
Route::get('/categories/fetchCategoryData', 'CategoriesController@fetchCategoryData');
Route::post('/categories/fetchCategoryDataById/{id}', 'CategoriesController@fetchCategoryDataById');
Route::post('/categories/edit/{id}', 'CategoriesController@editCategoryData');
Route::post('/categories/remove', 'CategoriesController@removeCategoryData');
Route::post('/categories/create', 'CategoriesController@create');

/*Locations*/
Route::get('/locations', 'LocationsController@index');
Route::get('/locations/fetchLocationData', 'LocationsController@fetchLocationData');
Route::post('/locations/fetchLocationDataById/{id}', 'LocationsController@fetchLocationDataById');
Route::post('/locations/edit/{id}', 'LocationsController@editLocationData');
Route::post('/locations/remove', 'LocationsController@removeLocationData');
Route::post('/locations/create', 'LocationsController@create');

/*Supplier*/
Route::get('/supplier', 'SupplierController@index');
Route::get('/supplier/fetchSupplierData', 'SupplierController@fetchSupplierData');
Route::post('/supplier/fetchSupplierDataById/{id}', 'SupplierController@fetchSupplierDataById');
Route::post('/supplier/edit/{id}', 'SupplierController@editSupplierData');
Route::post('/supplier/remove', 'SupplierController@removeSupplierData');
Route::post('/supplier/create', 'SupplierController@create');

//Route::get('/brands', function () {return view('vendor.adminlte.brands.index');});


/*Products*/
Route::get('/products/create', 'ProductsController@index');
Route::post('/products/create', 'ProductsController@create');
Route::get('/products/edit/{id}', 'ProductsController@editView');
Route::post('/products/edit', 'ProductsController@editProductData');
Route::post('/products/listJson', 'ProductsController@productListJson');
Route::get('/products', ['as' => 'products.manage', 'uses' => 'ProductsController@manageForList']);
Route::get('/products/fetchProductsData', 'ProductsController@fetchProductsData');
Route::get('/products/fetchProductsList/{id}', 'ProductsController@fetchProductsList');
Route::post('/products/remove', 'ProductsController@removeProductData');
Route::post('/products/fetchProductDataById', 'ProductsController@fetchProductDataById');

/* PO */
Route::get('/po/add', ['as' => 'po.add', 'uses' => 'POController@index']);
Route::get('po/edit/{id}', 'POController@editView');
Route::post('po/create', 'POController@create');
Route::get('po/manage', ['as' => 'po.manage', 'uses' => 'POController@poList']);
Route::get('po/fetchPOData', ['as' => 'fetchPOData', 'uses' => 'POController@fetchPOData']);
Route::post('po/edit/{id}', 'POController@editPOData');
Route::post('po/receiveAll', 'POController@receiveAll');
Route::post('po/partiallyReceive', 'POController@partiallyReceive');
Route::post('po/fetchPOItemsDataById', 'POController@fetchPOItemsDataById');
Route::get('po/view/{id}', 'POController@view');
Route::get('po/delete/{id}', 'POController@delete');
Route::get('po/printpo/{id}', 'POController@printPO');


/* Tax */
Route::get('/tax', 'TaxController@index');
Route::get('/tax/fetchTaxData', 'TaxController@fetchTaxData');
Route::post('/tax/fetchTaxDataById/{id}', 'TaxController@fetchTaxDataById');
Route::post('/tax/edit/{id}', 'TaxController@editTaxData');
Route::post('/tax/remove', 'TaxController@removeTaxData');
Route::post('/tax/create', 'TaxController@create');

/*transfers*/
Route::get('transfer/add', 'TransfersController@index');
Route::post('transfer/create', 'TransfersController@create');
Route::get('transfer/manage', ['as' => 'transfers.manage', 'uses' => 'TransfersController@transList']);
Route::get('transfer/fetchTransData', 'TransfersController@fetchTransData');
Route::get('transfer/edit/{id}', 'TransfersController@editView');
Route::post('transfer/edit/{id}', 'TransfersController@editTransferData');
Route::get('transfer/delete/{id}', 'TransfersController@delete');
Route::get('transfer/view/{id}', 'TransfersController@view');
Route::get('transfer/print/{id}', 'TransfersController@print');

/*stocks*/
Route::get('/stock/fetchProductsListWarehouseWise/{id}', 'StockController@fetchProductsListWarehouseWise');
Route::post('/stock/fetchProductsOneWarehouseWiseItem', 'StockController@fetchProductsOneWarehouseWiseItem');

/*customers*/
Route::get('customer/add', 'CustomerController@index');
Route::post('customer/create', 'CustomerController@create');
Route::get('customer/manage', ['as' => 'customer.manage', 'uses' => 'CustomerController@cusList']);
Route::get('customer/delete/{id}', 'CustomerController@deleteCustomer');
Route::get('customer/fetchTransData', 'CustomerController@fetchTransData');
Route::get('customer/edit/{id}', 'CustomerController@editView');
Route::post('customer/edit/{id}', 'CustomerController@update');

/*Biller*/
Route::get('biller/add', 'BillerController@index');
Route::post('biller/create', 'BillerController@create');
Route::get('biller/manage', ['as' => 'biller.manage', 'uses' => 'BillerController@billerList']);
Route::get('biller/delete/{id}', 'BillerController@deleteBiller');
Route::get('biller/fetchTransData', 'BillerController@fetchTransData');
Route::get('biller/edit/{id}', 'BillerController@editView');
Route::post('biller/edit/{id}', 'BillerController@update');

/* Sales */
Route::get('/sales/add', ['as' => 'sales.add', 'uses' => 'InvoiceController@index']);
Route::get('sales/edit/{id}', 'InvoiceController@editView');
Route::post('sales/create', 'InvoiceController@create');
Route::get('sales/manage', ['as' => 'sales.manage', 'uses' => 'InvoiceController@invoList']);
Route::get('sales/fetchSalesData', 'InvoiceController@fetchSalesData');
Route::post('sales/edit/{id}', 'InvoiceController@editInvoData');
Route::get('sales/view/{id}', 'InvoiceController@view');
Route::get('sales/delete/{id}', 'InvoiceController@delete');
Route::get('sales/print/{id}', 'InvoiceController@print');

/* Returns */
Route::get('/returns/add', ['as' => 'sales.add', 'uses' => 'StockReturnController@index']);
Route::get('/products/fetchProductsList', 'ProductsController@itemList');
Route::get('returns/edit/{id}', 'StockReturnController@editView');
Route::post('returns/create', 'StockReturnController@create');
Route::get('returns/manage', ['as' => 'returns.manage', 'uses' => 'StockReturnController@retnList']);
Route::get('returns/fetchReturnData', 'StockReturnController@fetchReturnData');
Route::post('returns/edit/{id}', 'StockReturnController@editReturnData');
Route::get('returns/view/{id}', 'StockReturnController@view');
Route::get('returns/delete/{id}', 'StockReturnController@delete');
Route::get('returns/print/{id}', 'StockReturnController@print');


/*Mailing*/
Route::get('/send/email/{id}', 'POController@mail');
Route::get('/send/sale/email/{id}', 'InvoiceController@mail');
Route::get('/send/transfers/email/{id}', 'TransfersController@mail');

/*Adjustment*/
Route::get('/adjustment/add', ['as' => 'adjustment.add', 'uses' => 'AdjustmentController@index']);
Route::post('adjustment/create', 'AdjustmentController@create');
Route::get('adjustment/manage', ['as' => 'adjustment.manage', 'uses' => 'AdjustmentController@adjustList']);
Route::get('adjustment/edit/{id}', 'AdjustmentController@editView');
Route::get('adjustment/fetchAdjData', 'AdjustmentController@fetchAdjData');
Route::post('adjustment/edit/{id}', 'AdjustmentController@editAdjData');
Route::get('adjustment/view/{id}', 'AdjustmentController@view');
Route::get('adjustment/delete/{id}', 'AdjustmentController@delete');

/*Roles*/
Route::get('/role', 'RoleController@index');
Route::get('/role/fetchRoleData', 'RoleController@fetchRoleData');
Route::post('/role/fetchRoleDataById/{id}', 'RoleController@fetchRoleDataById');
Route::post('/role/edit/{id}', 'RoleController@editRoleData');
Route::post('/role/remove', 'RoleController@removeRoleData');
Route::post('/role/create', 'RoleController@create');

Route::group(['middleware' => 'auth'], function () {
    //    Route::get('/link1', function ()    {
//        // Uses Auth Middleware
//    });

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
});
