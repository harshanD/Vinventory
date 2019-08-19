<?php
/**
 * Created by PhpStorm.
 * User: harshan
 * Date: 3/27/19
 * Time: 3:32 AM
 */
?>
@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <style>
        table, th {
            text-align: center;
        }
    </style>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">

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
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="page-header">
                            <i class="fa fa-globe"></i> AdminLTE, Inc.
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"
                                        data-toggle="tooltip"
                                        title="Collapse">
                                    <i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"
                                        data-toggle="tooltip"
                                        title="Remove">
                                    <i class="fa fa-times"></i></button>
                            </div>
                        </h2>

                    </div>
                    <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="well well-sm">
                    <div class="col-xs-4 border-right">
                        <div class="col-xs-2"><i class="fa fa-3x fa-building padding010 text-muted"></i></div>
                        <div class="col-xs-10">
                            <h2 class="">{{$suppliers->company }}</h2>
                            {{$suppliers->name }}<br>{{$suppliers->address }}<br>
                            <p></p>{{$suppliers->phone }}<br>{{$locations->email}}</div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-xs-4">
                        <div class="col-xs-2"><i class="fa fa-3x fa-truck padding010 text-muted"></i></div>
                        <div class="col-xs-10">
                            <h2 class="">{{$locations->name}}</h2>
                            {{$locations->code}}
                            <p> {{$locations->address}}</p><br>{{$locations->telephone}}<br>{{$locations->email}}</div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-xs-4 border-left">
                        <div class="col-xs-2"><i class="fa fa-3x fa-file-text-o padding010 text-muted"></i></div>
                        <div class="col-xs-10">
                            <h2 class="">Reference: {{$po->referenceCode}}</h2>
                            <p style="font-weight:bold;">{{$po->due_date}}</p>
                            <p style="font-weight:bold;">
                                Status: {{ \Config::get('constants.po_status_to_name.'.$po->status)}}</p>
                            <p style="font-weight:bold;">Payment Status: Pending</p>
                        </div>
                        <div class="col-xs-12 order_barcodes">
                            {!!  DNS2D::getBarcodeHTML(url()->current(), "QRCODE",2,2) !!}</div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <!-- Table row -->
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Unit Price</th>
                                <th>tax</th>
                                <th>Subtotal</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($po->poDetails as $key => $p)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$p->product->name}}</td>
                                    <td>{{$p->qty}}</td>
                                    <td>{{number_format($p->cost_price,2)}}</td>
                                    <td style="text-align: right">{{number_format($p->tax_val,2)}}</td>
                                    <td style="text-align: right">{{number_format($p->sub_total,2)}}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="4" style="text-align: right">Total (Rs)</td>
                                <td style="text-align: right">{{number_format($po->tax,2)}}</td>
                                <td style="text-align: right">{{number_format($po->grand_total,2)}}</td>
                            </tr>
                            <tr>
                                <td style="text-align: right" colspan="5">Total Amount (Rs)</td>
                                <td style="text-align: right">{{number_format($po->grand_total,2)}}</td>
                            </tr>
                            <tr>
                                <td style="text-align: right" colspan="5">Paid (Rs)</td>
                                <td style="text-align: right">{{number_format(00,2)}}</td>
                            </tr>
                            <tr>
                                <td style="text-align: right" colspan="5">Balance (Rs)</td>
                                <td style="text-align: right">{{number_format($po->grand_total,2)}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-xs-4 col-xs-offset-1 align-self-end" style="float: right">
                        <div class="well well-sm">
                            <p>Created by : {{$po->creator->name}} </p>
                            <p>Date: {{$po->creator->created_at}}</p>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- this row will not appear when printing -->
                <div class="row no-print">
                    <div class="col-xs-12">
                        <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i>
                            Print</a>
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i>
                            Submit Payment
                        </button>
                        <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
                            <i class="fa fa-download"></i> Generate PDF
                        </button>
                    </div>
                    {{--                <table id="poTable" class="table table-bordered table-striped">--}}
                    {{--                    <thead>--}}
                    {{--                    <tr>--}}
                    {{--                        <th>Date</th>--}}
                    {{--                        <th>Reference No</th>--}}
                    {{--                        <th>Supplier</th>--}}
                    {{--                        <th>Reserved status</th>--}}
                    {{--                        <th>Grand Total</th>--}}
                    {{--                        <th>Paid</th>--}}
                    {{--                        <th>Balance</th>--}}
                    {{--                        <th>PO Status</th>--}}
                    {{--                        <th>Actions</th>--}}

                    {{--                    </tr>--}}
                    {{--                    </thead>--}}
                    {{--                    <tbody>--}}
                    {{--                    <tr>--}}
                    {{--                        <td></td>--}}
                    {{--                        <td></td>--}}
                    {{--                        <td></td>--}}
                    {{--                        <td></td>--}}
                    {{--                        <td></td>--}}
                    {{--                        <td></td>--}}
                    {{--                        <td></td>--}}
                    {{--                        <td></td>--}}
                    {{--                        <td>--}}
                    {{--                            <a href="" class="btn btn-default"><i class="fa fa-edit"></i></a>--}}
                    {{--                            <a href="" class="btn btn-default"><i class="fa fa-trash"></i></a>--}}
                    {{--                        </td>--}}
                    {{--                    </tr>--}}

                    {{--                    </tbody>--}}
                    {{--                </table>--}}

                </div>
                <!-- /.box-body -->
            {{--<div class="box-footer">--}}
            {{--Footer--}}
            {{--</div>--}}
            <!-- /.box-footer-->
            </div>

            <!-- /.box -->

            <!-- remove location modal -->


            <!-- remove location modal -->


    </section>


    <script type="text/javascript">


    </script>
@endsection
