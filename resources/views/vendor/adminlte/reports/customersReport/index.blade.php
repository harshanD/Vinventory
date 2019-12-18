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
        <li class="active">Customer Report</li>
    </ol>
@stop

@section('content')
    <script src="{{ asset('custom/canvas/html2canvas.min.js') }}"></script>
    <section class="content">
        <!-- Default box -->

        <div class="box">

            <div class="box-header with-border">
                <h3 class="box-title">Customers Report</h3>

                <div class="box-tools pull-right">
                    <div class="btn-group">
                        <button class="btn btn-box-tool" type="button" data-toggle="collapse"
                                data-target="#multiCollapseExample1" aria-expanded="false"
                                aria-controls="multiCollapseExample1"><i class="fa fa-fw fa-filter"></i></button>
                        <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown"
                                aria-expanded="true">
                            <i class="fa fa-wrench"></i></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a style="cursor: pointer" onclick="getImage()"><i class="fa fa-file-image-o"></i>Save
                                    As
                                    Image</a></li>
                            <li><a style="cursor: pointer" onclick="getXls()"><i class="fa fa-file-excel-o"></i>Save As
                                    xls</a></li>

                        </ul>
                    </div>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>

                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                            title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>


            <div id="capture">
                <div class="box-body">
                    <div class="row collapse multi-collapse" id="multiCollapseExample1">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="suggest_product">From Date</label> <input type="text" name="from"
                                                                                      class="form-control ui-autocomplete-input input-xs"
                                                                                      id="datepicker"
                                                                                      autocomplete="off">
                                <input type="hidden" name="product" value="" id="report_product_id" class="input-xs">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="suggest_product">To Date</label> <input type="text" name="to"
                                                                                    class="form-control ui-autocomplete-input input-xs"
                                                                                    id="datepicker1"
                                                                                    autocomplete="off">
                                <input type="hidden" name="product" value="" id="report_product_id" class="input-xs">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <br>&nbsp;
                                <button class="btn btn-primary" id="search" data-toggle="modal"
                                        data-target="#addSupplierModal">Submit
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="<?= $table_responsive ?>">
                        <table id="manageTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Company</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email Address</th>
                                <th>Total Sales</th>
                                <th>Total Amount(Rs)</th>
                                <th>Paid(Rs)</th>
                                <th>Balance(Rs)</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
        {{--        <a  href="http://vinventory.offilne/storage/products/dISa5zosMaEf0Nar3YQcVL7kaXPPo2WTUGvsZa1R.jpeg"--}}
        {{--           class="image-link">--}}
        {{--            <img style="width: 100px;height: 100px" src="http://vinventory.offilne/storage/products/dISa5zosMaEf0Nar3YQcVL7kaXPPo2WTUGvsZa1R.jpeg" alt="">--}}
        {{--        </a>--}}
    </section>

@stop
@section('js')
    <script>
        $('#multiCollapseExample1').collapse({
            toggle: false
        })
        var imageDivId = 'capture';
        var imageSaveName = 'customers_()_';

        function getXls() {
            $("#manageTable").table2excel({
                exclude: ".noExl",
                name: "Worksheet Name",
                filename: imageSaveName,
                fileext: ".xls",
                exclude_img: false,
                exclude_links: true,
                exclude_inputs: true
            });
        }


        var manageTable;

        $(document).ready(function () {
            manageTable = $('#manageTable').DataTable({
                "processing": true,
                "columns": [
                    {data: 'company'},
                    {data: 'name'},
                    {data: 'phone'},
                    {data: 'email'},
                    {data: 'saleCount'},
                    {data: 'totAmount'},
                    {data: 'paid'},
                    {data: 'balance'},
                    {data: 'action'},
                ],
                ajax: {
                    "type": 'POST',
                    "url": '/reports/fetchCustomersData',
                    "data": {
                        '_token': '{{@csrf_token()}}',
                        'from': '' + $('#datepicker').val() + '',
                        'to': '' + $('#datepicker1').val() + '',
                    }
                },
                columnDefs: [
                    {
                        "targets": [5, 6, 7], // your case first column
                        "className": "text-right",
                    }, {
                        "targets": [4], // your case first column
                        "className": "text-center",
                    }
                ],
                "bDestroy": true
            });

            $("#search").on("click", function () {
                $('#manageTable').DataTable({
                    ajax: {
                        "type": 'POST',
                        url: "/reports/fetchCustomersData",
                        data: {
                            '_token': '{{@csrf_token()}}',
                            'from': '' + $('#datepicker').val() + '',
                            'to': '' + $('#datepicker1').val() + '',
                        }
                    },
                    "bDestroy": true,
                    "processing": true,
                    "columns": [
                        {data: 'company'},
                        {data: 'name'},
                        {data: 'phone'},
                        {data: 'email'},
                        {data: 'saleCount'},
                        {data: 'totAmount'},
                        {data: 'paid'},
                        {data: 'balance'},
                        {data: 'action'},
                    ],
                    columnDefs: [
                        {
                            "targets": [5, 6, 7], // your case first column
                            "className": "text-right",
                        }, {
                            "targets": [4], // your case first column
                            "className": "text-center",
                        }
                    ],
                });

            });
        })
    </script>
@endsection
