<?php
/**
 * Created by PhpStorm.
 * User: harshan
 * Date: 7/26/19
 * Time: 11:00 PM
 */
?>
@extends('adminlte::page')

@section('title', 'V-Inventory')

@section('content_header')
    <ol class="breadcrumb">
        <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Manage Roles</li>
    </ol>
@stop

@section('content')
    <!-- Main content -->
    <style>
        .avatar-pic {
            width: 100px;
            height: 100px;
        }
    </style>
    <section class="content">
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </div>
        @endif
        @if(\App\Http\Controllers\Permissions::getRolePermissions('createRole'))
            <button class="btn btn-primary" data-toggle="modal" data-target="#addRoleModal">Add Role</button>
            <br/> <br/>
    @endif
    <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Manage Roles</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                            title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div id="messages"></div>
                <div class="<?= $table_responsive ?>">
                    <table id="manageTable" class="table table-bordered responsive">
                        <thead>
                        <tr>
                            <th>Role Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>
                                <a href="" class="btn btn-default"><i class="fa fa-edit"></i></a>
                                <a href="" class="btn btn-default"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>

                        </tbody>
                    </table>

                </div>
            </div>
            <!-- /.box-body -->
        {{--<div class="box-footer">--}}
        {{--Footer--}}
        {{--</div>--}}
        <!-- /.box-footer-->
        </div>
        <!-- /.box -->

    </section>

    <!-- add role modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="addRoleModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Role</h4>
                </div>
                <div id="create_model_messages"></div>
                <form role="form" action="{{ url('role/create') }}" method="post" id="createRoleForm">
                    {{ @csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_supplier_name">Role Name<span class="mandatory"> *</span></label>
                            <input type="text" class="form-control" id="role_name" name="role_name"
                                   placeholder="Enter Company" autocomplete="off">
                            <p class="help-block" id="error_role_name"></p>
                        </div>
                        {{--                        <div class="form-group">--}}
                        <table class="table <?= $table_responsive ?>">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Create</th>
                                <th>Update</th>
                                <th>View</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Users</td>
                                <td><input type="checkbox" name="permission[]" value="createUser" class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="updateUser" class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="viewUser" class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="deleteUser" class="minimal"></td>
                            </tr>
                            <tr>
                                <td>Roles</td>
                                <td><input type="checkbox" name="permission[]" value="createRole" class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="updateRole" class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="viewRole" class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="deleteRole" class="minimal"></td>
                            </tr>
                            <tr>
                                <td>Brands</td>
                                <td><input type="checkbox" name="permission[]" value="createBrand" class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="updateBrand" class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="viewBrand" class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="deleteBrand" class="minimal"></td>
                            </tr>
                            <tr>
                                <td>Category</td>
                                <td><input type="checkbox" name="permission[]" value="createCategory" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="updateCategory" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="viewCategory" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="deleteCategory" class="minimal">
                                </td>
                            </tr>
                            <tr>
                                <td>Billers</td>
                                <td><input type="checkbox" name="permission[]" value="createBiller" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="updateBiller" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="viewBiller" class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="deleteBiller" class="minimal">
                                </td>
                            </tr>
                            <tr>
                                <td>Customers</td>
                                <td><input type="checkbox" name="permission[]" value="createCustomer" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="updateCustomer" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="viewCustomer" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="deleteCustomer" class="minimal">
                                </td>
                            </tr>
                            <tr>
                                <td>Suppliers</td>
                                <td><input type="checkbox" name="permission[]" value="createSupplier"
                                           class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="updateSupplier"
                                           class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="viewSupplier"
                                           class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="deleteSupplier"
                                           class="minimal"></td>
                            </tr>
                            <tr>
                                <td>WareHouses</td>
                                <td><input type="checkbox" name="permission[]" value="createWarehouse" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="updateWarehouse" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="viewWarehouse" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="deleteWarehouse" class="minimal">
                                </td>
                            </tr>
                            <tr>
                                <td>Products</td>
                                <td><input type="checkbox" name="permission[]" value="createProduct" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="updateProduct" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="viewProduct" class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="deleteProduct" class="minimal">
                                </td>
                            </tr>
                            <tr>
                                <td>Purchase Orders</td>
                                <td><input type="checkbox" name="permission[]" value="createOrder" class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="updateOrder" class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="viewOrder" class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="deleteOrder" class="minimal"></td>
                            </tr>
                            <tr>
                                <td>Sales</td>
                                <td><input type="checkbox" name="permission[]" value="createSale" class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="updateSale" class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="viewSale" class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="deleteSale" class="minimal"></td>
                            </tr>
                            <tr>
                                <td>Transfers</td>
                                <td><input type="checkbox" name="permission[]" value="createTransfer" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="updateTransfer" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="viewTransfer" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="deleteTransfer" class="minimal">
                                </td>
                            </tr>
                            <tr>
                                <td>Adjustment</td>
                                <td><input type="checkbox" name="permission[]" value="createAdjustment" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="updateAdjustment" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="viewAdjustment" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="deleteAdjustment" class="minimal">
                                </td>
                            </tr>
                            <tr>
                                <td>Returns</td>
                                <td><input type="checkbox" name="permission[]" value="createReturns" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="updateReturns" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="viewReturns" class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="deleteReturns" class="minimal">
                                </td>
                            </tr>
                            <tr>
                                <td>Tax</td>
                                <td><input type="checkbox" name="permission[]"
                                           value="createTax" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]"
                                           value="updateTax" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="viewTax"
                                           class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]"
                                           value="deleteTax" class="minimal">
                                </td>
                            </tr>
                            <tr>
                                <td>People</td>
                                <td> -</td>
                                <td> -</td>
                                <td><input type="checkbox" name="permission[]" value="viewPeople" class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td>Settings</td>
                                <td> -</td>
                                <td> -</td>
                                <td><input type="checkbox" name="permission[]" value="viewSettings" class="minimal">
                                </td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td>Reports</td>
                                <td> -</td>
                                <td> -</td>
                                <td><input type="checkbox" name="permission[]" value="viewReports" class="minimal"></td>
                                <td> -</td>
                            </tr>
                            {{-- reports start --}}
                            <tr>
                                <td></td>
                                <td colspan="2">Warehouse Stock Chart</td>
                                <td><input type="checkbox" name="permission[]" value="warehouseStockReport"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Product Quality Alerts</td>
                                <td><input type="checkbox" name="permission[]" value="productQualityAlerts"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Products Report</td>
                                <td><input type="checkbox" name="permission[]" value="productsReport"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Adjustments Report</td>
                                <td><input type="checkbox" name="permission[]" value="adjustmentsReport"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Category Report</td>
                                <td><input type="checkbox" name="permission[]" value="categoryReport"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Brands Report</td>
                                <td><input type="checkbox" name="permission[]" value="brandsReport"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Daily Sales</td>
                                <td><input type="checkbox" name="permission[]" value="dailySales"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Monthly Sales</td>
                                <td><input type="checkbox" name="permission[]" value="monthlySales"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Sales Report</td>
                                <td><input type="checkbox" name="permission[]" value="salesReport"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Payments Report</td>
                                <td><input type="checkbox" name="permission[]" value="paymentsReport"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Daily Purchases</td>
                                <td><input type="checkbox" name="permission[]" value="dailyPurchases"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Monthly Purchases</td>
                                <td><input type="checkbox" name="permission[]" value="monthlyPurchases"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Purchases Report</td>
                                <td><input type="checkbox" name="permission[]" value="purchasesReport"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Customers Report</td>
                                <td><input type="checkbox" name="permission[]" value="customersReport"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Suppliers Report</td>
                                <td><input type="checkbox" name="permission[]" value="suppliersReport"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            {{-- reports end--}}
                            <tr>
                                <td>Notifications</td>
                                <td> -</td>
                                <td> -</td>
                                <td><input type="checkbox" name="permission[]" value="notifications" class="minimal">
                                </td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Quantity Alerts</td>
                                <td><input type="checkbox" name="permission[]" value="quantityAlerts"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">New Registered Users</td>
                                <td><input type="checkbox" name="permission[]" value="newRegisteredUsers"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            {{-- dashbord --}}
                            <tr>
                                <td>Dashboard - Overview Chart</td>
                                <td> -</td>
                                <td> -</td>
                                <td><input type="checkbox" name="permission[]" value="dashChart" class="minimal">
                                </td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td>Dashboard - Top 5</td>
                                <td> -</td>
                                <td> -</td>
                                <td><input type="checkbox" name="permission[]" value="dashTop" class="minimal">
                                </td>
                                <td> -</td>
                            </tr>
                            {{-- dashbord  end --}}
                            <tr>
                                <td>Purchase Order - Stock Receive</td>
                                <td> -</td>
                                <td> -</td>
                                <td><input type="checkbox" name="permission[]" value="poStockReceive"
                                           class="minimal">
                                </td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td>Purchase Order - Approve</td>
                                <td> -</td>
                                <td> -</td>
                                <td><input type="checkbox" name="permission[]" value="poApprove"
                                           class="minimal">
                                </td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td colspan="2">Purchase Order - Send EMail</td>
                                <td> -</td>
                                <td><input type="checkbox" name="permission[]" value="poMail"
                                           class="minimal">
                                </td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td colspan="2">Sales - Send EMail</td>
                                <td> -</td>
                                <td><input type="checkbox" name="permission[]" value="salesMail"
                                           class="minimal">
                                </td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td colspan="2">Transfers - Send EMail</td>
                                <td> -</td>
                                <td><input type="checkbox" name="permission[]" value="transfersMail"
                                           class="minimal">
                                </td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td>Profile</td>
                                <td> -</td>
                                <td> -</td>
                                <td><input type="checkbox" name="permission[]" value="viewProfile" class="minimal"></td>
                                <td> -</td>
                            </tr>
                            {{--                            <tr>--}}
                            {{--                                <td>Setting</td>--}}
                            {{--                                <td>-</td>--}}
                            {{--                                <td><input type="checkbox" name="permission[]" value="updateSetting" class="minimal">--}}
                            {{--                                </td>--}}
                            {{--                                <td> -</td>--}}
                            {{--                                <td> -</td>--}}
                            {{--                            </tr>--}}
                            </tbody>
                        </table>
                        {{--                        </div>--}}
                        <div class="form-group">
                            <label for="active">Role Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="0">Active</option>
                                <option value="1">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>

                </form>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- edit role modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="editRoleModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Role</h4>
                </div>
                <div id="edit_model_messages"></div>
                <form role="form" action="{{ url('role/edit') }}" method="post" id="updateRoleForm">
                    {{ @csrf_field() }}
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="edit_supplier_name">Role Name<span class="mandatory"> *</span></label>
                            <input type="text" class="form-control" id="edit_role" name="edit_role"
                                   placeholder="Enter Company" autocomplete="off">
                            <p class="help-block" id="error_e_role"></p>
                        </div>
                        <table class="table <?= $table_responsive ?>">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Create</th>
                                <th>Update</th>
                                <th>View</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Users</td>
                                <td><input type="checkbox" name="permission[]" value="createUser" id="createUser"
                                           class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="updateUser" id="updateUser"
                                           class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="viewUser" id="viewUser"
                                           class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="deleteUser" id="deleteUser"
                                           class="minimal"></td>
                            </tr>
                            <tr>
                                <td>Roles</td>
                                <td><input type="checkbox" name="permission[]" value="createRole" id="createRole"
                                           class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="updateRole" id="updateRole"
                                           class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="viewRole" id="viewRole"
                                           class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="deleteRole" id="deleteRole"
                                           class="minimal"></td>
                            </tr>
                            <tr>
                                <td>Brands</td>
                                <td><input type="checkbox" name="permission[]" value="createBrand" id="createBrand"
                                           class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="updateBrand" id="updateBrand"
                                           class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="viewBrand" id="viewBrand"
                                           class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="deleteBrand" id="deleteBrand"
                                           class="minimal"></td>
                            </tr>
                            <tr>
                                <td>Category</td>
                                <td><input type="checkbox" name="permission[]" value="createCategory"
                                           id="createCategory" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="updateCategory"
                                           id="updateCategory" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="viewCategory" id="viewCategory"
                                           class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="deleteCategory"
                                           id="deleteCategory" class="minimal">
                                </td>
                            </tr>
                            <tr>
                                <td>Billers</td>
                                <td><input type="checkbox" name="permission[]" value="createBiller" id="createBiller"
                                           class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="updateBiller" id="updateBiller"
                                           class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="viewBiller" id="viewBiller"
                                           class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="deleteBiller" id="deleteBiller"
                                           class="minimal">
                                </td>
                            </tr>
                            <tr>
                                <td>Customers</td>
                                <td><input type="checkbox" name="permission[]" value="createCustomer"
                                           id="createCustomer" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="updateCustomer"
                                           id="updateCustomer" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="viewCustomer" id="viewCustomer"
                                           class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="deleteCustomer"
                                           id="deleteCustomer" class="minimal">
                                </td>
                            </tr>
                            <tr>
                                <td>Suppliers</td>
                                <td><input type="checkbox" name="permission[]" value="createSupplier"
                                           id="createSupplier" class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="updateSupplier"
                                           id="updateSupplier" class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="viewSupplier"
                                           id="viewSupplier" class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="deleteSupplier"
                                           id="deleteSupplier" class="minimal"></td>
                            </tr>
                            <tr>
                                <td>WareHouses</td>
                                <td><input type="checkbox" name="permission[]" value="createWarehouse"
                                           id="createWarehouse" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="updateWarehouse"
                                           id="updateWarehouse" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="viewWarehouse" id="viewWarehouse"
                                           class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="deleteWarehouse"
                                           id="deleteWarehouse" class="minimal">
                                </td>
                            </tr>
                            <tr>
                                <td>Products</td>
                                <td><input type="checkbox" name="permission[]" value="createProduct" id="createProduct"
                                           class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="updateProduct" id="updateProduct"
                                           class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="viewProduct" id="viewProduct"
                                           class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="deleteProduct" id="deleteProduct"
                                           class="minimal">
                                </td>
                            </tr>
                            <tr>
                                <td>Purchase Orders</td>
                                <td><input type="checkbox" name="permission[]" value="createOrder" id="createOrder"
                                           class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="updateOrder" id="updateOrder"
                                           class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="viewOrder" id="viewOrder"
                                           class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="deleteOrder" id="deleteOrder"
                                           class="minimal"></td>
                            </tr>
                            <tr>
                                <td>Sales</td>
                                <td><input type="checkbox" name="permission[]" value="createSale" id="createSale"
                                           class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="updateSale" id="updateSale"
                                           class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="viewSale" id="viewSale"
                                           class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="deleteSale" id="deleteSale"
                                           class="minimal"></td>
                            </tr>
                            <tr>
                                <td>Transfers</td>
                                <td><input type="checkbox" name="permission[]" value="createTransfer"
                                           id="createTransfer" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="updateTransfer"
                                           id="updateTransfer" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="viewTransfer" id="viewTransfer"
                                           class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="deleteTransfer"
                                           id="deleteTransfer" class="minimal">
                                </td>
                            </tr>
                            <tr>
                                <td>Adjustment</td>
                                <td><input type="checkbox" name="permission[]" value="createAdjustment"
                                           id="createAdjustment" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="updateAdjustment"
                                           id="updateAdjustment" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="viewAdjustment"
                                           id="viewAdjustment" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="deleteAdjustment"
                                           id="deleteAdjustment" class="minimal">
                                </td>
                            </tr>
                            <tr>
                                <td>Returns</td>
                                <td><input type="checkbox" name="permission[]" value="createReturns" id="createReturns"
                                           class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="updateReturns" id="updateReturns"
                                           class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="viewReturns" id="viewReturns"
                                           class="minimal"></td>
                                <td><input type="checkbox" name="permission[]" value="deleteReturns" id="deleteReturns"
                                           class="minimal">
                                </td>
                            </tr>
                            <tr>
                                <td>Tax</td>
                                <td><input type="checkbox" name="permission[]"
                                           value="createTax" id="createTax" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]"
                                           value="updateTax" id="updateTax" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]" value="viewTax"
                                           id="viewTax" class="minimal">
                                </td>
                                <td><input type="checkbox" name="permission[]"
                                           value="deleteTax" id="deleteTax" class="minimal">
                                </td>
                            </tr>
                            <tr>
                                <td>People</td>
                                <td> -</td>
                                <td> -</td>
                                <td><input type="checkbox" name="permission[]" value="viewPeople" id="viewPeople"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td>Settings</td>
                                <td> -</td>
                                <td> -</td>
                                <td><input type="checkbox" name="permission[]" value="viewSettings" id="viewSettings"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td>Reports</td>
                                <td> -</td>
                                <td> -</td>
                                <td><input type="checkbox" name="permission[]" value="viewReports" id="viewReports"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            {{-- reports start --}}
                            <tr>
                                <td></td>
                                <td colspan="2">Warehouse Stock Chart</td>
                                <td><input type="checkbox" name="permission[]" value="warehouseStockReport"
                                           id="warehouseStockReport"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Product Quality Alerts</td>
                                <td><input type="checkbox" name="permission[]" value="productQualityAlerts"
                                           id=productQualityAlerts"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Products Report</td>
                                <td><input type="checkbox" name="permission[]" value="productsReport"
                                           id="productsReport"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Adjustments Report</td>
                                <td><input type="checkbox" name="permission[]" value="adjustmentsReport"
                                           id="adjustmentsReport"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Category Report</td>
                                <td><input type="checkbox" name="permission[]" value="categoryReport"
                                           id="categoryReport"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Brands Report</td>
                                <td><input type="checkbox" name="permission[]" value="brandsReport" id="brandsReport"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Daily Sales</td>
                                <td><input type="checkbox" name="permission[]" value="dailySales" id="dailySales"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Monthly Sales</td>
                                <td><input type="checkbox" name="permission[]" value="monthlySales" id="monthlySales"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Sales Report</td>
                                <td><input type="checkbox" name="permission[]" value="salesReport" id="salesReport"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Payments Report</td>
                                <td><input type="checkbox" name="permission[]" value="paymentsReport"
                                           id="paymentsReport"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Daily Purchases</td>
                                <td><input type="checkbox" name="permission[]" value="dailyPurchases"
                                           id="dailyPurchases"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Monthly Purchases</td>
                                <td><input type="checkbox" name="permission[]" value="monthlyPurchases"
                                           id="monthlyPurchases"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Purchases Report</td>
                                <td><input type="checkbox" name="permission[]" value="purchasesReport"
                                           id="purchasesReport"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Customers Report</td>
                                <td><input type="checkbox" name="permission[]" value="customersReport"
                                           id="customersReport"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Suppliers Report</td>
                                <td><input type="checkbox" name="permission[]" value="suppliersReport"
                                           id="suppliersReport"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            {{-- reports end--}}
                            <tr>
                                <td>Notifications</td>
                                <td> -</td>
                                <td> -</td>
                                <td><input type="checkbox" name="permission[]" value="notifications" id="notifications"
                                           class="minimal">
                                </td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Quantity Alerts</td>
                                <td><input type="checkbox" name="permission[]" value="quantityAlerts"
                                           id="quantityAlerts"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">New Registered Users</td>
                                <td><input type="checkbox" name="permission[]" value="newRegisteredUsers"
                                           id="newRegisteredUsers"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            {{-- dashbord --}}
                            <tr>
                                <td>Dashboard - Overview Chart</td>
                                <td> -</td>
                                <td> -</td>
                                <td><input type="checkbox" name="permission[]" value="dashChart" id="dashChart"
                                           class="minimal">
                                </td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td>Dashboard - Top 5</td>
                                <td> -</td>
                                <td> -</td>
                                <td><input type="checkbox" name="permission[]" value="dashTop" id="dashTop"
                                           class="minimal">
                                </td>
                                <td> -</td>
                            </tr>
                            {{-- dashbord  end --}}
                            <tr>
                                <td>Purchase Order - Stock Receive</td>
                                <td> -</td>
                                <td> -</td>
                                <td><input type="checkbox" name="permission[]" value="poStockReceive"
                                           id="poStockReceive"
                                           class="minimal">
                                </td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td>Purchase Order - Approve</td>
                                <td> -</td>
                                <td> -</td>
                                <td><input type="checkbox" name="permission[]" value="poApprove" id="poApprove"
                                           class="minimal">
                                </td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td colspan="2">Purchase Order - Send EMail</td>
                                <td> -</td>
                                <td><input type="checkbox" name="permission[]" value="poMail" id="poMail"
                                           class="minimal">
                                </td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td colspan="2">Sales - Send EMail</td>
                                <td> -</td>
                                <td><input type="checkbox" name="permission[]" value="salesMail" id="salesMail"
                                           class="minimal">
                                </td>
                                <td> -</td>
                            </tr>
                            <tr>
                                <td colspan="2">Transfers - Send EMail</td>
                                <td> -</td>
                                <td><input type="checkbox" name="permission[]" value="transfersMail" id="transfersMail"
                                           class="minimal">
                                </td>
                                <td> -</td>
                            </tr>

                            <tr>
                                <td>Profile</td>
                                <td> -</td>
                                <td> -</td>
                                <td><input type="checkbox" name="permission[]" value="viewProfile" id="viewProfile"
                                           class="minimal"></td>
                                <td> -</td>
                            </tr>
                            {{--                            <tr>--}}
                            {{--                                <td>Setting</td>--}}
                            {{--                                <td>-</td>--}}
                            {{--                                <td><input type="checkbox" name="permission[]" value="updateSetting" id="updateSetting"--}}
                            {{--                                           class="minimal">--}}
                            {{--                                </td>--}}
                            {{--                                <td> -</td>--}}
                            {{--                                <td> -</td>--}}
                            {{--                            </tr>--}}
                            </tbody>
                        </table>

                        <div class="form-group">
                            <label for="active">Status</label>
                            <select class="form-control" id="edit_status" name="edit_status">
                                <option value="0">Active</option>
                                <option value="1">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>

                </form>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- remove role modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="removeRoleModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Remove Role</h4>
                </div>

                <form role="form" action="{{ url('role/remove') }}" method="post" id="removeRoleForm">
                    <div class="modal-body">
                        <p>Do you really want to remove?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script type="text/javascript">
        var manageTable;

        $(document).ready(function () {
            // initialize the datatable
            manageTable = $('#manageTable').DataTable({
                'ajax': '/role/fetchRoleData',
                "columns": [
                    null,
                    {"orderable": false},
                    {"orderable": false},
                ],
                columnDefs: [
                    {
                        "targets": [2, 1], // your case first column
                        "className": "text-center",
                    },
                ],
            });

            // submit the create from
            $("#createRoleForm").unbind('submit').on('submit', function () {
                var form = $(this);

                // remove the text-danger
                $(".text-danger").remove();

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(), // /converting the form data into array and sending it to server
                    dataType: 'json',
                    success: function (response) {

                        manageTable.ajax.reload(null, false);

                        if (response.success === true) {
                            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + response.messages +
                                '</div>');


                            // hide the modal
                            $("#addRoleModal").modal('hide');

                            // reset the form
                            $("#createRoleForm")[0].reset();
                            $("#createRoleForm .form-group").removeClass('has-error').removeClass('has-success');

                        } else {

                            if (response.messages instanceof Object) {
                                $.each(response.messages, function (index, value) {
                                    var id = $("#" + index);

                                    id.closest('.form-group')
                                        .removeClass('has-error')
                                        .removeClass('has-success')
                                        .addClass(value.length > 0 ? 'has-error' : 'has-success');

                                    id.after(value);

                                });
                            } else {
                                $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                    '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + response.messages +
                                    '</div>');
                            }
                        }
                    },
                    error: function (response) {
                        // alert(response.responseJSON.errors.role)
                        if (response.responseJSON.errors.role_name) {
                            $('#error_role_name').html(response.responseJSON.errors.role_name[0]);
                        }


                    }
                });
                return false;
            });
        });

        function editRole(id) {
            $.ajax({
                url: '/role/fetchRoleDataById/' + id,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                dataType: 'json',
                success: function (response) {

                    $('.minimal').prop("checked", false);

                    $("#edit_role").val(response.name);

                    if (response.permission != null) {
                        for (var i = 0; i < (response.permission).length; i++) {
                            $("#" + response.permission[i]).prop("checked", true);
                            // $("#" + response.permission[i]).val(response.permission[i]);
                        }
                    }
                    $("#edit_status").val(response.status).change();

                    // submit the edit from
                    $("#updateRoleForm").unbind('submit').bind('submit', function () {
                        var form = $(this);

                        // remove the text-danger
                        $(".text-danger").remove();

                        $.ajax({
                            url: form.attr('action') + '/' + id,
                            type: form.attr('method'),
                            data: form.serialize(), // /converting the form data into array and sending it to server
                            dataType: 'json',
                            success: function (response) {

                                manageTable.ajax.reload(null, false);

                                if (response.success === true) {
                                    $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + response.messages +
                                        '</div>');


                                    // hide the modal
                                    $("#editRoleModal").modal('hide');
                                    // reset the form
                                    $("#updateRoleForm .form-group").removeClass('has-error').removeClass('has-success');

                                } else {

                                    if (response.messages instanceof Object) {
                                        $.each(response.messages, function (index, value) {
                                            var id = $("#" + index);

                                            id.closest('.form-group')
                                                .removeClass('has-error')
                                                .removeClass('has-success')
                                                .addClass(value.length > 0 ? 'has-error' : 'has-success');

                                            id.after(value);

                                        });
                                    } else {
                                        $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                            '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + response.messages +
                                            '</div>');
                                    }
                                }
                            },
                            error: function (response) {
                                if (response.responseJSON.errors.edit_role) {
                                    $('#error_e_role').html(response.responseJSON.errors.edit_role[0]);
                                }

                            }
                        });

                        return false;
                    });

                }
            });
        }

        function removeRole(id) {
            // submit the remove from
            $("#removeRoleForm").on('submit', function () {
                var form = $(this);

                // remove the text-danger
                $(".text-danger").remove();

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: {
                        role_id: id,
                        "_token": "{{ csrf_token() }}",
                    },
                    dataType: 'json',
                    success: function (response) {

                        manageTable.ajax.reload(null, false);

                        if (response.success === true) {
                            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + response.messages +
                                '</div>');


                            // hide the modal
                            $("#removeRoleModal").modal('hide');
                            // reset the form
                            $("#updateRoleForm .form-group").removeClass('has-error').removeClass('has-success');

                        } else {

                            if (response.messages instanceof Object) {
                                $.each(response.messages, function (index, value) {
                                    var id = $("#" + index);

                                    id.closest('.form-group')
                                        .removeClass('has-error')
                                        .removeClass('has-success')
                                        .addClass(value.length > 0 ? 'has-error' : 'has-success');

                                    id.after(value);

                                });
                            } else {
                                $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                    '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + response.messages +
                                    '</div>');
                            }
                        }
                    },
                });
                return false;
            });

        }
    </script>

@stop
