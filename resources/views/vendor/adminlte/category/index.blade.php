<?php
/**
 * Created by PhpStorm.
 * User: harshan
 * Date: 3/27/19
 * Time: 3:50 AM
 */
?>
@extends('adminlte::layouts.app')

@section('htmlheader_title')
    User Create
@endsection


@section('main-content')
    <!-- Main content -->
    <section class="content">
        <button class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add Category</button>
        <br /> <br />
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

                <table id="userTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
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
            <!-- /.box-body -->`
        {{--<div class="box-footer">--}}
        {{--Footer--}}
        {{--</div>--}}
        <!-- /.box-footer-->
        </div>
        <!-- /.box -->

    </section>


    <!-- edit brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="addModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Category</h4>
                </div>

                <form role="form" action="" method="post" id="updateForm">

                    <div class="modal-body">
                        <div id="messages"></div>

                        <div class="form-group">
                            <label for="edit_brand_name">Category Name</label>
                            <input type="text" class="form-control" id="edit_category_name" name="edit_category_name" placeholder="Enter category name" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="edit_active">Status</label>
                            <select class="form-control" id="edit_active" name="edit_active">
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
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

@endsection
