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

Route::get('/user/create', function () {return view('vendor.adminlte.users.create');});
Route::get('/user/manage', function () {return view('vendor.adminlte.users.index');});

Route::get('/brands', 'BrandsController@index');
Route::get('/brands/fetchBrandData', 'BrandsController@fetchBrandData');

Route::post('brands/create', 'BrandsController@create');
//Route::get('/brands', function () {return view('vendor.adminlte.brands.index');});

Route::get('/category', function () {return view('vendor.adminlte.category.index');});
Route::get('/location', function () {return view('vendor.adminlte.location.index');});
Route::get('/products/create', function () {return view('vendor.adminlte.products.create');});
Route::get('/products', function () {return view('vendor.adminlte.products.index');});


Route::group(['middleware' => 'auth'], function () {
    //    Route::get('/link1', function ()    {
//        // Uses Auth Middleware
//    });

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
});
