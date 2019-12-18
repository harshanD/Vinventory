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
        <li class="active">Manage Products</li>
    </ol>
@stop

@section('content')
    <style>
        .imgBorder {
            padding: 15px 15px 0;
            background-color: white;
            box-shadow: 0 1px 3px rgba(34, 25, 25, 0.4);
            -moz-box-shadow: 0 1px 2px rgba(34,25,25,0.4);
            -webkit-box-shadow: 0 1px 3px rgba(34, 25, 25, 0.4);
        }
    </style>
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Manage Products</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                            title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div id="messages"></div>
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
                    <table id="productsTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Image</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Brand</th>
                            <th>Category</th>
                            <th>Cost(Rs)</th>
                            <th>Price(Rs)</th>
                            <th>Quantity</th>
                            <th>Unit</th>
                            <th>Alert Quantity</th>
                            <th>status</th>

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
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <a href="" class="btn btn-default"><i class="fa fa-view"></i></a>
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
        <div class="modal fade" tabindex="-1" role="dialog" id="removeProductModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Remove Product</h4>
                    </div>

                    <form role="form" action="{{ url('products/remove') }}" method="post" id="removeProductForm">
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

        <div class="modal fade" tabindex="-1" role="dialog" id="productViewModal">
        </div>
    </section>

@endsection


@section('js')
    <script type="text/javascript">
        var manageTable;
        $(document).ready(function () {
            // table = $("table.table").dataTable();
            // table.fnPageChange("first", 1);
            // initialize the datatable
            manageTable = $('#productsTable').DataTable({
                'ajax': '/products/fetchProductsData',
                "processing": true,
                "serverSide": true,
                "columns": [
                    {data: 'image', name: 'actions', orderable: false, searchable: false},
                    {data: 'item_code'},
                    {data: 'name'},
                    {data: 'brand'},
                    {data: 'category'},
                    {data: 'cost_price'},
                    {data: 'selling_price'},
                    {data: 'qty'},
                    {data: 'unitName'},
                    {data: 'reorder_level'},
                    {data: 'status', orderable: false, searchable: false},
                    {data: 'action', name: 'actions', orderable: false, searchable: false}
                ],
                columnDefs: [
                    {
                        "targets": [5, 6, 7],
                        "className": "text-right",
                    },
                    {
                        "targets": [0, 8, 9, 10, 11],
                        "className": "text-center",
                    },

                ],
            });

        })


        function removeProduct(id) {
            // submit the remove from
            $("#removeProductForm").on('submit', function () {
                var form = $(this);

                // remove the text-danger
                $(".text-danger").remove();

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: {
                        id: id,
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
                            $("#removeProductModal").modal('hide');
                            // reset the form
                            $("#removeProductForm .form-group").removeClass('has-error').removeClass('has-success');

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

        $(function () {
            setTimeout(
                function () {
                    $('.image-link-custom').viewbox({
                        setTitle: true,
                        margin: 20,
                        resizeDuration: 300,
                        openDuration: 200,
                        closeDuration: 200,
                        closeButton: true,
                        navButtons: true,
                        closeOnSideClick: true,
                        nextOnContentClick: true
                    });
                }, 1000);
        });

        function showProductDetails(id) {
            $.ajax({
                url: "/products/showItem",
                type: 'POST',
                data: {
                    id: id,
                    "_token": "{{ csrf_token() }}",
                },
                dataType: 'json',
                success: function (response) {
                    $('#productViewModal').html(response.html);
                    $('#productViewModal').modal({
                        show: 'true'
                    });

                },
            });
        }

    </script>
@endsection
