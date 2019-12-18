<?php
/**
 * Created by PhpStorm.
 * User: harshan
 * Date: 72/6/19
 * Time: 10:50 PM
 */
?>
@extends('adminlte::page')

@section('title', 'V-Inventory')

@section('content_header')
    <ol class="breadcrumb">
        <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Manage Categories</li>
    </ol>
@stop

@section('content')
    <!-- Main content -->
    <section class="content">

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </div>
        @endif
        @if(\App\Http\Controllers\Permissions::getRolePermissions('createCategory'))
            <button class="btn btn-primary" data-toggle="modal" data-target="#addCategoryModal">Add Category</button>
            <br/> <br/>
    @endif
    <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Manage Categories</h3>

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
                            <th>Category Name</th>
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

    <!-- add category modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="addCategoryModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Category</h4>
                </div>
                <div id="create_model_messages"></div>
                <form role="form" action="{{ url('categories/create') }}" method="post" id="createCategoryForm">
                    {{ @csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_code_name">Code</label>
                            <input type="text" class="form-control" id="code" name="code"
                                   placeholder="Enter Code" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="edit_category_name">Category Name<span class="mandatory"> *</span></label>
                            <input type="text" class="form-control" id="category" name="category"
                                   placeholder="Enter Category name" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="edit_description">Description</label>
                            <input type="text" class="form-control" id="description" name="description"
                                   placeholder="Enter Description" autocomplete="off">
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

    <!-- edit category modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="editCategoryModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Category</h4>
                </div>
                <div id="edit_model_messages"></div>
                <form role="form" action="{{ url('categories/edit') }}" method="post" id="updateCategoryForm">
                    {{ @csrf_field() }}
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="edit_code_name">Code</label>
                            <input type="text" class="form-control" id="edit_code" name="edit_code"
                                   placeholder="Enter Code" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="edit_category_name">Category Name</label>
                            <input type="text" class="form-control" id="edit_category_name" name="edit_category_name"
                                   placeholder="Enter Category name" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="edit_description">Description</label>
                            <input type="text" class="form-control" id="edit_description" name="edit_description"
                                   placeholder="Enter Description" autocomplete="off">
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

    <!-- remove category modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="removeCategoryModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Remove Category</h4>
                </div>

                <form role="form" action="{{ url('categories/remove') }}" method="post" id="removeCategoryForm">
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
                'ajax': '/categories/fetchCategoryData',
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
            $("#createCategoryForm").unbind('submit').on('submit', function () {
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
                            $("#addCategoryModal").modal('hide');

                            // reset the form
                            $("#createCategoryForm")[0].reset();
                            $("#createCategoryForm .form-group").removeClass('has-error').removeClass('has-success');

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

                        $("#create_model_messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                            '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + response.responseJSON.errors.category +
                            '</div>');
                    }
                });
                return false;
            });
        });

        function editCategory(id) {
            $.ajax({
                url: '/categories/fetchCategoryDataById/' + id,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                dataType: 'json',
                success: function (response) {

                    $("#edit_category_name").val(response.name);
                    $("#edit_code").val(response.code);
                    $("#edit_description").val(response.description);
                    $("#edit_status").val(response.status);

                    // submit the edit from
                    $("#updateCategoryForm").unbind('submit').bind('submit', function () {
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
                                    $("#editCategoryModal").modal('hide');
                                    // reset the form
                                    $("#updateCategoryForm .form-group").removeClass('has-error').removeClass('has-success');

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
                                console.log(response.responseJSON.errors)
                                $("#edit_model_messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                    '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + response.responseJSON.errors.edit_category_name +
                                    '</div>');
                            }
                        });

                        return false;
                    });

                }
            });
        }

        function removeCategory(id) {
            // submit the remove from
            $("#removeCategoryForm").on('submit', function () {
                var form = $(this);

                // remove the text-danger
                $(".text-danger").remove();

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: {
                        category_id: id,
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
                            $("#removeCategoryModal").modal('hide');
                            // reset the form
                            $("#updateCategoryForm .form-group").removeClass('has-error').removeClass('has-success');

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
