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
        <li><a href="{{url('transfer/manage')}}">Transfers Manage</a></li>
        <li class="active">View Transfer</li>
    </ol>
@stop

@section('content')
    <section class="content">

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Transfers</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                            title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>


            <div class="box">
                <div class="modal-content">
                    <div class="modal-body">

                        <div class="well well-sm">
                            <div class="row bold">
                                <div class="col-xs-4">Date: {{$transfers->created_at}}
                                    <br>Reference: {{$transfers->tr_reference_code}}</div>
                                <div class="col-xs-6 pull-right text-right order_barcodes">
                                    <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($transfers->referenceCode, 'C93',3, 70)}}"
                                         alt="barcode"/>&nbsp;&nbsp;
                                    <img src="data:image/png;base64,{{DNS2D::getBarcodePNG(url()->current(), "QRCODE",2.5,2.5)}}"
                                         alt="barcode"/>

                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                To:<br>
                                <h3 style="margin-top:10px;">{{$transfers->toLocation->name }}
                                    ( {{$transfers->toLocation->code }} )</h3>
                                <p></p>
                                <p>{{$transfers->toLocation->address }}</p>
                                <p></p>
                                <p>{{$transfers->toLocation->telephone }}<br>{{$transfers->toLocation->email}}</p></div>
                            <div class="col-xs-6">
                                From:
                                <h3 style="margin-top:10px;">{{$transfers->fromLocation->name }}
                                    ( {{$transfers->fromLocation->code }} )</h3>
                                <p></p>
                                <p>{{$transfers->fromLocation->address }}</p>
                                <p></p>
                                <p>{{$transfers->fromLocation->telephone }}<br>{{$transfers->fromLocation->email}}</p>
                            </div>
                        </div>
                        <div class="<?= $table_responsive ?>">
                            <table class="table table-bordered table-hover table-striped order-table">
                                <thead>
                                <tr>
                                    <th style="text-align:center; vertical-align:middle;">No.</th>
                                    <th style="vertical-align:middle;">Product</th>
                                    <th style="text-align:center; vertical-align:middle;">Quantity</th>
                                    <th style="text-align:center; vertical-align:middle;">Unit Cost (Rs)</th>
                                    <th style="text-align:center; vertical-align:middle;">Tax</th>
                                    <th style="text-align:center; vertical-align:middle;">Subtotal</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($stock->stockItems as $key => $p)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$p->products->name}}( {{$p->products->item_code }} )</td>
                                        <td>{{$p->qty}}</td>
                                        <td style="text-align: right">{{number_format(($p->cost_price-(($p->cost_price*$p->tax_per)/(100+$p->tax_per))),2)}}</td>
                                        <td style="text-align: right">{{number_format((($p->cost_price*$p->tax_per)/(100+$p->tax_per)),2)}}</td>
                                        <td style="text-align: right">{{number_format($p->cost_price*$p->qty,2)}}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="4" style="text-align:right;">Total (Rs)
                                    </td>
                                    <td style="text-align:right;">
                                        {{number_format($transfers->tot_tax,2)}}
                                    </td>
                                    <td style="text-align:right;">
                                        {{number_format($transfers->grand_total,2)}}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="text-align:right; font-weight:bold;">Total Amount (Rs)
                                    </td>
                                    <td style="text-align:right; font-weight:bold;">  {{number_format($transfers->grand_total,2)}}</td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-xs-4 col-xs-offset-1 align-self-end" style="float: right">
                                <div class="well well-sm">
                                    <p>Created by : {{$transfers->creator->name}} </p>
                                    <p>Date: {{date('Y-m-d H:i:s')}}</p>
                                </div>
                            </div>

                        </div>
                        <!-- this row will not appear when printing -->
                        <div class="row no-print">
                            <div class="col-xs-12">
                                {{--                        <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i>--}}
                                {{--                            Print</a>--}}
                                <div style="float: right">
                                    <a class="btn btn-success" href='{{url('transfer/print/'.$transfers->id)}}'>
                                        <i class="fa fa-file-pdf-o"></i><span class="hidden-sm hidden-xs"> PDF</span>
                                    </a>
                                    @if(\App\Http\Controllers\Permissions::getRolePermissions('updateTransfer'))
                                        <a class="btn btn-warning" href='{{url('transfer/edit/'.$transfers->id)}}'>
                                            <i class="glyphicon glyphicon-edit"></i><span
                                                    class="hidden-sm hidden-xs"> Edit</span>
                                        </a>
                                    @endif
                                    @if(\App\Http\Controllers\Permissions::getRolePermissions('deleteTransfer'))
                                        <a class="btn btn-danger" title="" data-toggle="popover"
                                           data-content="<div style='width:150px;'><p>Are you sure?</p><a class='btn btn-danger' href='{{url('transfer/delete/'.$transfers->id)}}'>Yes I'm sure</a> <button class='btn bpo-close'>No</button></div>"
                                           data-html="true" data-placement="top"
                                           data-original-title="<b>Delete Purchase</b>">
                                            <i class="fa fa-trash-o"></i> <span
                                                    class="hidden-sm hidden-xs">Delete</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal -->
        </div><!-- /.modal -->


    </section>


    <script type="text/javascript">
        $(document).ready(function () {
            $('[data-toggle="popover"]').popover();
        })
    </script>
@endsection
