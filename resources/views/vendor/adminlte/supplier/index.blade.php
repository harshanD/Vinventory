<?php
/**
 * Created by PhpStorm.
 * User: harshan
 * Date: 7/26/19
 * Time: 11:00 PM
 */
?>
@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Dashboard</h1>
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
        <div id="messages"></div>
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </div>
        @endif
        <button class="btn btn-primary" data-toggle="modal" data-target="#addSupplierModal">Add Supplier</button>
        <br/> <br/>
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Manage Suppliers</h3>

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

                <table id="manageTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Company</th>
                        <th>Supplier Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
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
            <!-- /.box-body -->
        {{--<div class="box-footer">--}}
        {{--Footer--}}
        {{--</div>--}}
        <!-- /.box-footer-->
        </div>
        <!-- /.box -->

    </section>

    <!-- add supplier modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="addSupplierModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Supplier</h4>
                </div>
                <div id="create_model_messages"></div>
                <form role="form" action="{{ url('supplier/create') }}" method="post" id="createSupplierForm">
                    {{ @csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_supplier_name">Company *</label>
                            <input type="text" class="form-control" id="company" name="company"
                                   placeholder="Enter Company" autocomplete="off">
                            <p class="help-block" id="error_company"></p>
                        </div>
                        <div class="form-group">
                            <label for="edit_supplier_name">Supplier Name *</label>
                            <input type="text" class="form-control" id="supplier" name="supplier"
                                   placeholder="Enter Supplier name" autocomplete="off">
                            <p class="help-block" id="error_supplier"></p>

                        </div>
                        <div class="form-group">
                            <label for="edit_supplier_name">Phone *</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                   placeholder="Enter Phone" autocomplete="off">
                            <p class="help-block" id="error_phone"></p>
                        </div>
                        <div class="form-group">
                            <label for="edit_supplier_name">Email *</label>
                            <input type="text" class="form-control" id="email" name="email"
                                   placeholder="Enter Email" autocomplete="off">
                            <p class="help-block" id="error_email"></p>
                        </div>
                        <div class="form-group">
                            <label for="edit_supplier_name">Address *</label>
                            <input type="text" class="form-control" id="address" name="address"
                                   placeholder="Enter Address" autocomplete="off">
                            <p class="help-block" id="error_address"></p>
                        </div>
                        <div class="form-group">
                            <label for="active">Status</label>
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

    <!-- edit supplier modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="editSupplierModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Supplier</h4>
                </div>
                <div id="edit_model_messages"></div>
                <form role="form" action="{{ url('supplier/edit') }}" method="post" id="updateSupplierForm">
                    {{ @csrf_field() }}
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="edit_supplier_name">Company *</label>
                            <input type="text" class="form-control" id="edit_company" name="edit_company"
                                   placeholder="Enter Company" autocomplete="off">
                            <p class="help-block" id="error_e_company"></p>
                        </div>
                        <div class="form-group">
                            <label for="edit_supplier_name">Supplier Name *</label>
                            <input type="text" class="form-control" id="edit_supplier" name="edit_supplier"
                                   placeholder="Enter Supplier name" autocomplete="off">
                            <p class="help-block" id="error_e_supplier"></p>
                        </div>

                        <div class="form-group">
                            <label for="edit_supplier_name">Phone *</label>
                            <input type="text" class="form-control" id="edit_phone" name="edit_phone"
                                   placeholder="Enter Phone" autocomplete="off">
                            <p class="help-block" id="error_e_phone"></p>
                        </div>
                        <div class="form-group">
                            <label for="edit_supplier_name">Email *</label>
                            <input type="text" class="form-control" id="edit_email" name="edit_email"
                                   placeholder="Enter Email" autocomplete="off">
                            <p class="help-block" id="error_e_email"></p>
                        </div>
                        <div class="form-group">
                            <label for="edit_supplier_name">Address *</label>
                            <input type="text" class="form-control" id="edit_address" name="edit_address"
                                   placeholder="Enter Address" autocomplete="off">
                            <p class="help-block" id="error_e_address"></p>
                        </div>
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

    <!-- remove supplier modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="removeSupplierModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Remove Supplier</h4>
                </div>

                <form role="form" action="{{ url('supplier/remove') }}" method="post" id="removeSupplierForm">
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
                'ajax': '/supplier/fetchSupplierData',
                'order': []
            });

            // submit the create from
            $("#createSupplierForm").unbind('submit').on('submit', function () {
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
                            $("#addSupplierModal").modal('hide');

                            // reset the form
                            $("#createSupplierForm")[0].reset();
                            $("#createSupplierForm .form-group").removeClass('has-error').removeClass('has-success');

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
                        // alert(response.responseJSON.errors.supplier)
                        if (response.responseJSON.errors.supplier) {
                            $('#error_supplier').html(response.responseJSON.errors.supplier[0]);
                        }
                        if (response.responseJSON.errors.company) {
                            $('#error_company').html(response.responseJSON.errors.company[0]);
                        }
                        if (response.responseJSON.errors.address) {
                            $('#error_address').html(response.responseJSON.errors.address[0]);
                        }
                        if (response.responseJSON.errors.phone) {
                            $('#error_phone').html(response.responseJSON.errors.phone[0]);
                        }
                        if (response.responseJSON.errors.email) {
                            $('#error_email').html(response.responseJSON.errors.email[0]);
                        }


                    }
                });
                return false;
            });
        });

        function editSupplier(id) {
            $.ajax({
                url: '/supplier/fetchSupplierDataById/' + id,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                dataType: 'json',
                success: function (response) {

                    $("#edit_supplier").val(response.name);
                    $("#edit_company").val(response.company);
                    $("#edit_phone").val(response.phone);
                    $("#edit_address").val(response.address);
                    $("#edit_email").val(response.email);
                    $("#edit_status").val(response.status);

                    // submit the edit from
                    $("#updateSupplierForm").unbind('submit').bind('submit', function () {
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
                                    $("#editSupplierModal").modal('hide');
                                    // reset the form
                                    $("#updateSupplierForm .form-group").removeClass('has-error').removeClass('has-success');

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
                                if (response.responseJSON.errors.edit_supplier) {
                                    $('#error_e_supplier').html(response.responseJSON.errors.edit_supplier[0]);
                                }
                                if (response.responseJSON.errors.edit_company) {
                                    $('#error_e_company').html(response.responseJSON.errors.edit_company[0]);
                                }
                                if (response.responseJSON.errors.edit_address) {
                                    $('#error_e_address').html(response.responseJSON.errors.edit_address[0]);
                                }
                                if (response.responseJSON.errors.edit_phone) {
                                    $('#error_e_phone').html(response.responseJSON.errors.edit_phone[0]);
                                }
                                if (response.responseJSON.errors.edit_email) {
                                    $('#error_e_email').html(response.responseJSON.errors.edit_email[0]);
                                }

                            }
                        });

                        return false;
                    });

                }
            });
        }

        function removeSupplier(id) {
            // submit the remove from
            $("#removeSupplierForm").on('submit', function () {
                var form = $(this);

                // remove the text-danger
                $(".text-danger").remove();

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: {
                        supplier_id: id,
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
                            $("#removeSupplierModal").modal('hide');
                            // reset the form
                            $("#updateSupplierForm .form-group").removeClass('has-error').removeClass('has-success');

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
