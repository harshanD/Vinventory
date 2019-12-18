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
        <li class="active">Manage Warehouses</li>
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
        @if(\App\Http\Controllers\Permissions::getRolePermissions('createWarehouse'))
            <button class="btn btn-primary" data-toggle="modal" data-target="#addLocationModal">Add Warehouse</button>
            <br/> <br/>
    @endif
    <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Manage Warehouses</h3>

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
                    <table id="manageTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Code</th>
                            <th>Warehouse Name</th>
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
            </div>
            <!-- /.box-body -->
        {{--<div class="box-footer">--}}
        {{--Footer--}}
        {{--</div>--}}
        <!-- /.box-footer-->
        </div>
        <!-- /.box -->

    </section>

    <!-- add location modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="addLocationModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Warehouse</h4>
                </div>
                <div id="create_model_messages"></div>
                <form role="form" action="{{ url('locations/create') }}" method="post" id="createLocationForm">
                    {{ @csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_location_name">Code<span class="mandatory"> *</span></label>
                            <input type="text" class="form-control" id="code" name="code"
                                   placeholder="Enter Code" autocomplete="off">
                            <p class="help-block" id="error_code"></p>
                        </div>
                        <div class="form-group">
                            <label for="edit_location_name">Warehouse Name<span class="mandatory"> *</span></label>
                            <input type="text" class="form-control" id="location" name="location"
                                   placeholder="Enter Warehouse name" autocomplete="off">
                            <p class="help-block" id="error_location"></p>

                        </div>
                        <div class="form-group">
                            <label for="edit_location_name">Contact Person<span class="mandatory"> *</span></label>
                            <input type="text" class="form-control" id="person" name="person"
                                   placeholder="Enter Contact Person" autocomplete="off">
                            <p class="help-block" id="error_person"></p>
                        </div>
                        <div class="form-group">
                            <label for="edit_location_name">Phone<span class="mandatory"> *</span></label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                   placeholder="Enter Phone" autocomplete="off">
                            <p class="help-block" id="error_phone"></p>
                        </div>
                        <div class="form-group">
                            <label for="edit_location_name">Email<span class="mandatory"> *</span></label>
                            <input type="text" class="form-control" id="email" name="email"
                                   placeholder="Enter Phone" autocomplete="off">
                            <p class="help-block" id="error_email"></p>
                        </div>
                        <div class="form-group">
                            <label for="edit_location_name">Address<span class="mandatory"> *</span></label>
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

    <!-- edit location modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="editLocationModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Warehouse</h4>
                </div>
                <div id="edit_model_messages"></div>
                <form role="form" action="{{ url('locations/edit') }}" method="post" id="updateLocationForm">
                    {{ @csrf_field() }}
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="edit_location_name">Code<span class="mandatory"> *</span></label>
                            <input type="text" class="form-control" id="edit_code" name="edit_code"
                                   placeholder="Enter Code" autocomplete="off">
                            <p class="help-block" id="error_e_code"></p>
                        </div>
                        <div class="form-group">
                            <label for="edit_location_name">Warehouse Name<span class="mandatory"> *</span></label>
                            <input type="text" class="form-control" id="edit_location" name="edit_location"
                                   placeholder="Enter Warehouse name" autocomplete="off">
                            <p class="help-block" id="error_e_location"></p>
                        </div>
                        <div class="form-group">
                            <label for="edit_location_name">Contact Person<span class="mandatory"> *</span></label>
                            <input type="text" class="form-control" id="edit_person" name="edit_person"
                                   placeholder="Enter Contact Person" autocomplete="off">
                            <p class="help-block" id="error_e_person"></p>
                        </div>
                        <div class="form-group">
                            <label for="edit_location_name">Phone<span class="mandatory"> *</span></label>
                            <input type="text" class="form-control" id="edit_phone" name="edit_phone"
                                   placeholder="Enter Phone" autocomplete="off">
                            <p class="help-block" id="error_e_phone"></p>
                        </div>
                        <div class="form-group">
                            <label for="edit_location_name">Email<span class="mandatory"> *</span></label>
                            <input type="text" class="form-control" id="edit_email" name="edit_email"
                                   placeholder="Enter Phone" autocomplete="off">
                            <p class="help-block" id="error_e_email"></p>
                        </div>
                        <div class="form-group">
                            <label for="edit_location_name">Address<span class="mandatory"> *</span></label>
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

    <!-- remove location modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="removeLocationModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Remove Warehouse</h4>
                </div>

                <form role="form" action="{{ url('locations/remove') }}" method="post" id="removeLocationForm">
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
                'ajax': '/locations/fetchLocationData',
                "columns": [
                    null,
                    null,
                    {"orderable": false},
                    {"orderable": false},
                ],
                columnDefs: [
                    {
                        "targets": [2, 3], // your case first column
                        "className": "text-center",
                    },
                ],
            });

            // submit the create from
            $("#createLocationForm").unbind('submit').on('submit', function () {
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
                            $("#addLocationModal").modal('hide');

                            // reset the form
                            $("#createLocationForm")[0].reset();
                            $("#createLocationForm .form-group").removeClass('has-error').removeClass('has-success');

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
                        // alert(response.responseJSON.errors.location)
                        if (response.responseJSON.errors.location) {
                            $('#error_location').html(response.responseJSON.errors.location[0]);
                        }
                        if (response.responseJSON.errors.code) {
                            $('#error_code').html(response.responseJSON.errors.code[0]);
                        }
                        if (response.responseJSON.errors.address) {
                            $('#error_address').html(response.responseJSON.errors.address[0]);
                        }
                        if (response.responseJSON.errors.person) {
                            $('#error_person').html(response.responseJSON.errors.person[0]);
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

        function editLocation(id) {
            $.ajax({
                url: '/locations/fetchLocationDataById/' + id,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                dataType: 'json',
                success: function (response) {

                    $("#edit_location").val(response.name);
                    $("#edit_code").val(response.code);
                    $("#edit_person").val(response.person);
                    $("#edit_phone").val(response.phone);
                    $("#edit_address").val(response.address);
                    $("#edit_email").val(response.email);
                    $("#edit_status").val(response.status);

                    // submit the edit from
                    $("#updateLocationForm").unbind('submit').bind('submit', function () {
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
                                    $("#editLocationModal").modal('hide');
                                    // reset the form
                                    $("#updateLocationForm .form-group").removeClass('has-error').removeClass('has-success');

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
                                if (response.responseJSON.errors.edit_location) {
                                    $('#error_e_location').html(response.responseJSON.errors.edit_location[0]);
                                }
                                if (response.responseJSON.errors.edit_code) {
                                    $('#error_e_code').html(response.responseJSON.errors.edit_code[0]);
                                }
                                if (response.responseJSON.errors.edit_ddress) {
                                    $('#error_e_address').html(response.responseJSON.errors.edit_address[0]);
                                }
                                if (response.responseJSON.errors.edit_person) {
                                    $('#error_e_person').html(response.responseJSON.errors.edit_person[0]);
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

        function removeLocation(id) {
            // submit the remove from
            $("#removeLocationForm").on('submit', function () {
                var form = $(this);

                // remove the text-danger
                $(".text-danger").remove();

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: {
                        location_id: id,
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
                            $("#removeLocationModal").modal('hide');
                            // reset the form
                            $("#updateLocationForm .form-group").removeClass('has-error').removeClass('has-success');

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
