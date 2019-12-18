<?php
/**
 * Created by PhpStorm.
 * User: harshan
 * Date: 3/27/19
 * Time: 3:32 AM
 */
?>
@extends('adminlte::page')

@section('title', 'V-Inventory')

@section('content_header')
    <ol class="breadcrumb">
        <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"><a href="{{url('user/manage')}}">Manage Users</a></li>
    </ol>
@stop

@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Manage Users</h3>

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
                @if(session()->has('message'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <strong> <span class="glyphicon glyphicon-ok-sign"></span>
                        </strong> {{ session()->get('message') }}
                    </div>
                @endif
                @if(session()->has('error'))
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <strong> <span class="glyphicon glyphicon-exclamation-sign"></span>
                        </strong> {{ session()->get('error') }}
                    </div>
                @endif
                <div class="<?= $table_responsive ?>">
                    <table id="userTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Email Verification</th>
                            <th>status</th>
                            <th>Phone</th>
                            <th>Role</th>

                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
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

        <!-- remove supplier modal -->
        <div class="modal fade" tabindex="-1" role="dialog" id="deleteUserModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Delete Confirm</h4>
                    </div>

                    <form id="deleteProductForm">
                        <div class="modal-body">
                            <p>Do you really want to remove?</p>
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-primary" href="" role="button" id="deleteBtn">Delete</a>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>


                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </section>


    <script type="text/javascript">
        var manageTable;
        $(document).ready(function () {
            // table = $("table.table").dataTable();
            // table.fnPageChange("first", 1);
            // initialize the datatable
            manageTable = $('#userTable').DataTable({
                'ajax': '/user/fetchUsersData',
                "columns": [
                    null,
                    null,
                    {"orderable": false},
                    {"orderable": false},
                    null,
                    null,
                    {"orderable": false},
                ],
                columnDefs: [
                    {
                        "targets": [2, 4, 6], // your case first column
                        "className": "text-center",
                    }
                ],
            });
        })

        function removeUser() {
            $('#deleteUserModal').modal({
                hidden: 'true'
            });

            $('#deleteBtn').attr("href", ('/user/delete/') + id);
        }
    </script>
@endsection
