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
    <ol class="breadcrumb">
        <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Manage Suppliers</li>
    </ol>
@stop

@section('content')
    <script src="{{ asset('custom/canvas/html2canvas.min.js') }}"></script>
    <section class="content">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="ion ion-ios-cart-outline"></i></span>


                    <div class="info-box-content">
                        <span class="info-box-text">Sale Amount</span>
                        <span class="info-box-number">{{ $header['saleAmount'] }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-money"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Paid</span>
                        <span class="info-box-number">{{ $header['totPaid'] }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="glyphicon glyphicon-plane"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Due Amount</span>
                        <span class="info-box-number">{{ $header['dueAmount'] }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="glyphicon glyphicon-heart-empty"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Sales</span>
                        <span class="info-box-number">{{ $header['totSale'] }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <div class="box">

            <div class="box-header with-border">
                <h3 class="box-title">Customers Report</h3>

                {{--                <div class="box-tools pull-right">--}}

                {{--                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"--}}
                {{--                            title="Collapse">--}}
                {{--                        <i class="fa fa-minus"></i></button>--}}

                {{--                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"--}}
                {{--                            title="Remove">--}}
                {{--                        <i class="fa fa-times"></i></button>--}}
                {{--                </div>--}}
            </div>


            <div id="capture">
                <div class="box-body">
                    <div class="nav-tabs-custom  table-responsive">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab">Sales</a></li>
                            <li><a href="#tab_2" data-toggle="tab">Payments</a></li>
                            {{--                            <li><a href="#tab_3" data-toggle="tab">Returns</a></li>--}}
                            <li class="pull-right">
                                <div class="btn-group">


                                    <button class="btn btn-box-tool" type="button" data-toggle="collapse"
                                            data-target=".multiCollapseExample1" aria-expanded="false"
                                            aria-controls="multiCollapseExample"><i class="fa fa-fw fa-filter"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool dropdown-toggle"
                                            data-toggle="dropdown"
                                            aria-expanded="true">
                                        <i class="fa fa-wrench"></i></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a style="cursor: pointer" onclick="getImage()"><i
                                                        class="fa fa-file-image-o"></i>Save
                                                As
                                                Image</a></li>
                                        <li><a style="cursor: pointer" onclick="getXlsSales()"><i
                                                        class="fa fa-file-excel-o"></i>Save As xls - Sales </a></li>
                                        <li><a style="cursor: pointer" onclick="getXlsPays()"><i
                                                        class="fa fa-file-excel-o"></i>Save As xls - Payments</a></li>

                                    </ul>
                                </div>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div class="row collapse multi-collapse multiCollapseExample1"
                                     id="multiCollapseExample1">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="suggest_product">Created By</label>
                                            <select class="form-control select2" id="saleCreatedUser"
                                                    name="saleCreatedUser">
                                                <option value="0">Select User</option>
                                                @foreach($soldUsers as $user)
                                                    <option
                                                        <?= (app('request')->input('createdUser') == $user->creator->id) ? 'selected' : ''; ?> value="{{$user->creator->id}}">{{$user->creator->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="suggest_product">Biller</label>
                                            <select class="form-control select2" id="saleBiller" name="saleBiller">
                                                <option value="0">Select Biller</option>
                                                @foreach($billers as $blr)
                                                    <option
                                                        <?= (app('request')->input('biller') == $blr->id) ? 'selected' : ''; ?> value="{{$blr->id}}">{{$blr->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="suggest_product">Warehouse</label>
                                            <select class="form-control select2" id="saleWarehouse"
                                                    name="saleWarehouse">
                                                <option value="0">Select Warehouse</option>
                                                @foreach($warehouses as $ware)
                                                    <option
                                                        <?= (app('request')->input('warehouse') == $ware->id) ? 'selected' : ''; ?> value="{{$ware->id}}">{{$ware->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="suggest_product">From Date</label> <input type="text"
                                                                                                  name="datepicker"
                                                                                                  class="form-control ui-autocomplete-input input-xs"
                                                                                                  id="datepicker"
                                                                                                  autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="suggest_product">To Date</label> <input type="text"
                                                                                                name="datepicker1"
                                                                                                class="form-control ui-autocomplete-input input-xs"
                                                                                                id="datepicker1"
                                                                                                autocomplete="off">

                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <br>&nbsp;
                                            <button class="btn btn-primary" id="SaleSearch" data-toggle="modal"
                                                    data-target="#addSupplierModal">Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <table class="table table-hover" id="manageTable">
                                    <thead>
                                    <th align="center">Date</th>
                                    <th align="center">Reference No</th>
                                    <th align="center">Biller</th>
                                    <th align="center">Product</th>
                                    <th align="center">Grand Total</th>
                                    <th align="center">Paid</th>
                                    <th align="center">Balance</th>
                                    <th align="center">Payment Status</th>
                                    </thead>

                                </table>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_2">
                                <div class="row collapse multi-collapse multiCollapseExample1"
                                     id="multiCollapseExample1">

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="suggest_product">From Date</label> <input type="text"
                                                                                                  name="payFrom"
                                                                                                  class="form-control ui-autocomplete-input input-xs"
                                                                                                  id="payFrom"
                                                                                                  autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="suggest_product">To Date</label>
                                            <input type="text" name="payTo"
                                                   class="form-control ui-autocomplete-input input-xs"
                                                   id="payTo"
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <br>&nbsp;
                                            <button class="btn btn-primary" id="paySearch" data-toggle="modal"
                                                    data-target="#addSupplierModal">Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-hover" id="paymentManageTable">
                                    <thead>
                                    <th align="center">Date</th>
                                    <th align="center">Payment Reference</th>
                                    <th align="center">Sale Reference</th>
                                    <th align="center">Paid By</th>
                                    <th align="center">Amount</th>
                                    </thead>

                                </table>
                            </div>
                            <!-- /.tab-pane -->
                            {{--                            <div class="tab-pane" id="tab_3">--}}
                            {{--                                <div class="row collapse multi-collapse multiCollapseExample1"--}}
                            {{--                                     id="multiCollapseExample1">--}}

                            {{--                                    <div class="col-sm-4">--}}
                            {{--                                        <div class="form-group">--}}
                            {{--                                            <label for="suggest_product">From Date</label> <input type="text"--}}
                            {{--                                                                                                  name="returnFrom"--}}
                            {{--                                                                                                  class="form-control ui-autocomplete-input input-xs"--}}
                            {{--                                                                                                  id="returnFrom"--}}
                            {{--                                                                                                  autocomplete="off">--}}
                            {{--                                        </div>--}}
                            {{--                                    </div>--}}
                            {{--                                    <div class="col-sm-4">--}}
                            {{--                                        <div class="form-group">--}}
                            {{--                                            <label for="suggest_product">To Date</label> <input type="text"--}}
                            {{--                                                                                                name="returnTo"--}}
                            {{--                                                                                                class="form-control ui-autocomplete-input input-xs"--}}
                            {{--                                                                                                id="returnTo"--}}
                            {{--                                                                                                autocomplete="off">--}}
                            {{--                                        </div>--}}
                            {{--                                    </div>--}}
                            {{--                                    <div class="col-sm-4">--}}
                            {{--                                        <div class="form-group">--}}
                            {{--                                            <br>&nbsp;--}}
                            {{--                                            <button class="btn btn-primary" id="returnSearch" data-toggle="modal"--}}
                            {{--                                                    data-target="#addSupplierModal">Submit--}}
                            {{--                                            </button>--}}
                            {{--                                        </div>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                                <table class="table table-hover" id="ReturnManageTable">--}}
                            {{--                                    <thead>--}}
                            {{--                                    <th align="center">#</th>--}}
                            {{--                                    <th align="center">Date</th>--}}
                            {{--                                    <th align="center">Reference No</th>--}}
                            {{--                                    <th align="center">From</th>--}}
                            {{--                                    <th align="center">To</th>--}}
                            {{--                                    <th align="center">Status</th>--}}
                            {{--                                    <th align="center">Amount</th>--}}
                            {{--                                    </thead>--}}

                            {{--                                </table>--}}
                            {{--                            </div><!-- /.tab-pane -->--}}
                        </div>
                        <!-- /.tab-pane -->
                    </div>

                    {{--                    </div>--}}

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

        var imageDivId = 'capture';
        var imageSaveName = 'customers__';

        function getXlsSales() {
            $("#manageTable").table2excel({
                exclude: ".noExl",
                name: "Worksheet Name",
                filename: imageSaveName + '_sales',
                fileext: ".xls",
                exclude_img: false,
                exclude_links: true,
                exclude_inputs: true
            });
        }

        function getXlsPays() {
            $("#manageTable").table2excel({
                exclude: ".noExl",
                name: "Worksheet Name",
                filename: imageSaveName + '_payments',
                fileext: ".xls",
                exclude_img: false,
                exclude_links: true,
                exclude_inputs: true
            });
        }


        var manageTable;

        var pageURL = window.location.href;
        var customerId = pageURL.substr(pageURL.lastIndexOf('/') + 1);


        $(document).ready(function () {
            $('#manageTable').DataTable({
                "processing": true,
                "columns": [
                    {data: 'date'},
                    {data: 'reference'},
                    {data: 'biller'},
                    {data: 'products'},
                    {data: 'grandTotal'},
                    {data: 'paid'},
                    {data: 'balance'},
                    {data: 'paymentStatus'},
                ],
                ajax: {
                    "type": 'POST',
                    "url": '/reports/fetchCustomerSaleData',
                    "data": {
                        '_token': '{{@csrf_token()}}',
                        'customerId': customerId,
                    }
                },
                columnDefs: [
                    {
                        "targets": [5, 6, 4], // your case first column
                        "className": "text-right",
                    }, {
                        "targets": [7], // your case first column
                        "className": "text-center",
                    }
                ],
                "bDestroy": true
            });

            $('#paymentManageTable').DataTable({
                "processing": true,
                "columns": [
                    {data: 'date'},
                    {data: 'payReference'},
                    {data: 'saleReference'},
                    {data: 'paidBy'},
                    {data: 'amount'},
                ],
                ajax: {
                    "type": 'POST',
                    "url": '/reports/fetchCustomerPaymentData',
                    "data": {
                        '_token': '{{@csrf_token()}}',
                        'customerId': customerId,
                    }
                },
                columnDefs: [
                    {
                        "targets": [4], // your case first column
                        "className": "text-right",
                    }, {
                        "targets": [1, 3], // your case first column
                        "className": "text-center",
                    }
                ],
                "bDestroy": true
            });

            $("#SaleSearch").on("click", function () {
                $('#manageTable').DataTable({
                    "processing": true,
                    "columns": [
                        {data: 'date'},
                        {data: 'reference'},
                        {data: 'biller'},
                        {data: 'products'},
                        {data: 'grandTotal'},
                        {data: 'paid'},
                        {data: 'balance'},
                        {data: 'paymentStatus'},
                    ],
                    ajax: {
                        "type": 'POST',
                        url: "/reports/fetchCustomerSaleData",
                        "data": {
                            '_token': '{{@csrf_token()}}',
                            'SaleTo': '' + $('#datepicker1').val() + '',
                            'SaleFrom': '' + $('#datepicker').val() + '',
                            'saleWarehouse': '' + $('#saleWarehouse').val() + '',
                            'saleBiller': '' + $('#saleBiller').val() + '',
                            'saleCreatedUser': '' + $('#saleCreatedUser').val() + '',
                            'customerId': customerId,
                        }
                    },
                    "bDestroy": true,

                    columnDefs: [
                        {
                            "targets": [5, 6, 4], // your case first column
                            "className": "text-right",
                        }, {
                            "targets": [7], // your case first column
                            "className": "text-center",
                        }
                    ],
                });

            });

            $("#paySearch").on("click", function () {
                $('#paymentManageTable').DataTable({
                    "processing": true,
                    "columns": [
                        {data: 'date'},
                        {data: 'payReference'},
                        {data: 'saleReference'},
                        {data: 'paidBy'},
                        {data: 'amount'},
                    ],
                    ajax: {
                        "type": 'POST',
                        url: "/reports/fetchCustomerPaymentData",
                        "data": {
                            '_token': '{{@csrf_token()}}',
                            'payTo': '' + $('#payTo').val() + '',
                            'payFrom': '' + $('#payFrom').val() + '',
                            'customerId': customerId,
                        }
                    },
                    "bDestroy": true,

                    columnDefs: [
                        {
                            "targets": [4], // your case first column
                            "className": "text-right",
                        }, {
                            "targets": [2], // your case first column
                            "className": "text-center",
                        }
                    ],
                });

            });
        })

        $('#payFrom').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        })
        $('#payTo').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        })
        $('#returnFrom').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        })
        $('#returnTo').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        })

    </script>
@endsection
