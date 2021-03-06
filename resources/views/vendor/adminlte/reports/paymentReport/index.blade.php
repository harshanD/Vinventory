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
        <li class="active">Payment Report</li>
    </ol>
@stop

@section('content')
    <script src="{{ asset('custom/canvas/html2canvas.min.js') }}"></script>
    <section class="content">
        <!-- Default box -->

        <div class="box">

            <div class="box-header with-border">
                <h3 class="box-title">Payments Report</h3>

                <div class="box-tools pull-right">

                    <button class="btn btn-box-tool" type="button" data-toggle="collapse"
                            data-target="#multiCollapseExample1" aria-expanded="false"
                            aria-controls="multiCollapseExample1"><i class="fa fa-fw fa-filter"></i></button>
                    <div class="btn-group">
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
                    <form action="payment" method="get">
                        <div class="row collapse multi-collapse" id="multiCollapseExample1">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="suggest_product">Payment Reference</label>
                                    <input class="form-control" type="text" name="payRef" id="payRef"
                                           value="{{app('request')->input('payRef') }}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="suggest_product">Paid By</label>
                                    <select class="form-control select2" id="createdUser" name="payBy">
                                        <option
                                            <?= (app('request')->input('payBy') == 0) ? 'selected' : ''; ?> value="0">
                                            Select
                                        </option>
                                        <option
                                            <?= (app('request')->input('payBy') == 'cash') ? 'selected' : ''; ?> value="cash">
                                            Cash
                                        </option>
                                        <option
                                            <?= (app('request')->input('payBy') == 'cheque') ? 'selected' : ''; ?> value="cheque">
                                            Cheque
                                        </option>
                                        <option
                                            <?= (app('request')->input('payBy') == 'other') ? 'selected' : ''; ?> value="other">
                                            Other
                                        </option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="suggest_product">Sale Reference</label>
                                    <input class="form-control" type="text" name="saleRef" id="saleRef"
                                           value="{{app('request')->input('saleRef') }}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="suggest_product">Purchase Reference</label>
                                    <input class="form-control" type="text" name="purRef" id="purRef"
                                           value="{{app('request')->input('purRef') }}">
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="suggest_product">Customer</label>
                                    <select class="form-control select2" id="customer" name="customer">
                                        <option value="0">Select Customer</option>
                                        @foreach($customers as $cus)
                                            <option
                                                <?= (app('request')->input('customer') == $cus->id) ? 'selected' : ''; ?> value="{{$cus->id}}">{{$cus->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="suggest_product">Biller</label>
                                    <select class="form-control select2" id="biller" name="biller">
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
                                    <label for="suggest_product">Supplier</label>
                                    <select class="form-control select2" id="supplier" name="supplier">
                                        <option value="0">Select Supplier</option>
                                        @foreach($suppliers as $supplier)
                                            <option
                                                <?= (app('request')->input('supplier') == $supplier->id) ? 'selected' : ''; ?> value="{{$supplier->id}}">{{$supplier->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="suggest_product">Cheque Number</label>
                                    <input type="text" name="cNumber" value="{{app('request')->input('cNumber')}}"
                                           class="form-control ui-autocomplete-input input-xs"
                                           autocomplete="off">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="suggest_product">Created By</label>
                                    <select class="form-control select2" id="createdUser" name="createdUser">
                                        <option value="0">Select User</option>
                                        @foreach($payUsers as $user)
                                            <option
                                                <?= (app('request')->input('createdUser') == $user->creator->id) ? 'selected' : ''; ?> value="{{$user->creator->id}}">{{$user->creator->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="suggest_product">From Date</label>
                                    <input type="text" name="from" value="{{app('request')->input('from')}}"
                                           class="form-control ui-autocomplete-input input-xs"
                                           id="datepicker"
                                           autocomplete="off">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="suggest_product">To Date</label>
                                    <input type="text" name="to" value="{{app('request')->input('to')}}"
                                           class="form-control ui-autocomplete-input input-xs"
                                           id="datepicker1"
                                           autocomplete="off">
                                </div>
                            </div>
                            <div class="col-sm-4" style="float: right">
                                <div class="form-group">
                                    <br>&nbsp;
                                    <button class="btn btn-primary" id="submit" name="submit" type="submit">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="<?= $table_responsive ?>">
                        <table id="manageTable" class="table table-bordered table-striped table table-hover">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Payment Reference</th>
                                <th>Sale Reference</th>
                                <th>Purchase Reference</th>
                                <th>Paid By</th>
                                <th>Amount(Rs)</th>
                                <th>LastUpdated Time</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($filteredData as $key=>$filData)
                                <tr
                                >
                                    <th>{{$filData['date']}}</th>
                                    <th>{{$filData['paymentReference']}}</th>
                                    <th>{{$filData['saleReference']}}</th>
                                    <th>{{$filData['purReference']}}</th>
                                    <th>{{$filData['paidBy']}}</th>
                                    <th>{{number_format($filData['amount'],2)}}</th>
                                    <th>{{$filData['lastUpdated']}}</th>

                                </tr>

                            @endforeach
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

    <script>
        // $('#multiCollapseExample1').collapse({
        //     toggle: false
        // })
        var imageDivId = 'capture';
        var imageSaveName = 'payments_';

        function getXls() {
            $("#manageTable").table2excel({
                exclude: ".noExl",
                name: "Worksheet Name",
                filename: imageSaveName + '{{date('Y-m-d H:i:s')}}',
                fileext: ".xls",
                exclude_img: false,
                exclude_links: true,
                exclude_inputs: true
            });
        }


        var manageTable;

        $(document).ready(function () {
            $('#manageTable').DataTable({
                "order": [[0, "desc"]],
                columnDefs: [
                    {
                        "targets": [0, 1, 2, 3, 4, 6], // your case first column
                        "className": "text-center",
                    },
                    {
                        "targets": [5], // your case first column
                        "className": "text-right",
                    }
                ],
            });
        });

        $('#btn1').click(function () {
            $('.collapse').hide();
            // $('#demo1').hide();
            $('#demo').show();
        });

    </script>


@stop
