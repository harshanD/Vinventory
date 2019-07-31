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


Route::get('/user/manage', ['as'=>'users.manage', 'uses' =>'HomeController@userList']);
Route::get('/user/fetchUsersData', 'HomeController@fetchUsersData');
Route::get('/user/edit/{id}', 'HomeController@userEditView');
Route::post('user/editSave', 'HomeController@editSave');

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

Route::get('/products/create', function () {
    return view('vendor.adminlte.products.create');
});
Route::get('/products', function () {
    return view('vendor.adminlte.products.index');
});


Route::group(['middleware' => 'auth'], function () {
    //    Route::get('/link1', function ()    {
//        // Uses Auth Middleware
//    });

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
});
