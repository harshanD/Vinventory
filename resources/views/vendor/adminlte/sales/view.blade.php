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
    <ol class="breadcrumb">
        <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url('sales/manage')}}">Sale Manage</a></li>
        <li class="active">View Sale</li>
    </ol>
@stop

@section('content')
    <section>

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Sales</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                            title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="col-lg-12">

                <div class="well well-sm">
                    <div class="col-xs-4 border-right">
                        <div class="col-xs-2"><i class="fa fa-3x fa-user padding010 text-muted"></i></div>
                        <div class="col-xs-10">
                            <h2 class="">{{$customer->name}}</h2>
                            {{$customer->address}}<br><br>{{$customer->phone}}<br>{{$customer->email}}
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-xs-4 border-right">
                        <div class="col-xs-2"><i class="fa fa-3x fa-building padding010 text-muted"></i></div>
                        <div class="col-xs-10">
                            <h2 class="">{{$biller->name}}</h2>
                            {{$biller->address}} <br>
                            <p><br></p>{{$biller->phone}}<br>{{$biller->email}}</div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-xs-4">
                        <div class="col-xs-2"><i class="fa fa-3x fa-building-o padding010 text-muted"></i></div>
                        <div class="col-xs-10">
                            <h2 class="">{{$location->name}}</h2>

                            <p>{{$location->address}}</p><br>{{$location->phone}}<br>{{$location->email}}</div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
                <div class="clearfix"></div>
                <div class="col-xs-7 pull-right">
                    <div class="col-xs-12 text-right order_barcodes">
                        <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($sales->invoice_code, 'C93',3, 70)}}"
                             alt="barcode"/>&nbsp;&nbsp;
                        <img src="data:image/png;base64,{{DNS2D::getBarcodePNG(url()->current(), "QRCODE",2.5,2.5)}}"
                             alt="barcode"/></div>
                    <div class="clearfix"></div>
                </div>
                <div class="col-xs-5">
                    <div class="col-xs-2"><i class="fa fa-3x fa-file-text-o padding010 text-muted"></i></div>
                    <div class="col-xs-10">
                        <h2 class="">Reference: {{$sales->invoice_code}}</h2>
                        <p style="font-weight:bold;">Date: {{date('Y-m-d H:i:s')}}</p>
                        <p style="font-weight:bold;">Sale
                            Status: {{\Config::get('constants.i_sale_status_value.'.$sales->sales_status) }}</p>
                        <p style="font-weight:bold;">Payment Status
                            : {{\Config::get('constants.i_payment_status_value.'.$sales->payment_status) }}</p>
                        <p>Due Date: {{$sales->invoice_date}}</p>
                        <p>&nbsp;</p>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
                <div class="<?= $table_responsive ?>">
                    <table class="table table-bordered table-hover table-striped print-table order-table">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Description (Code)</th>
                            <th>Quantity</th>
                            <th hidden style="text-align:center; vertical-align:middle;">Serial No</th>
                            <th style="padding-right:20px;">Unit Price</th>
                            <th style="padding-right:20px; text-align:center; vertical-align:middle;">Tax</th>
                            <th style="padding-right:20px; text-align:center; vertical-align:middle;">Discount</th>
                            <th style="padding-right:20px;">Subtotal</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <?php $tot = 0;$incr = 0;$taxTot = 0;$disTot = 0; ?>
                            @foreach($sales->invoiceItems as $item)
                                <?php $tot += $item->sub_total;
                                $taxTot += $item->tax_val;
                                $disTot += $item->discount;
                                ?>
                                <td style="text-align:center; width:40px; vertical-align:middle;">{{++$incr}}</td>
                                <td style="vertical-align:middle;">
                                    {{$item->products->name}} [ {{$item->products->item_code}} ]
                                </td>
                                <td style="width: 100px; text-align:center; vertical-align:middle;"> {{$item->qty}} </td>
                                <td hidden></td>
                                <td style="text-align:right; width:120px; padding-right:10px;">
                                    {{number_format($item->selling_price,2)}}
                                </td>
                                <td style="width: 120px; text-align:right; vertical-align:middle;">
                                    {{--                                <small>(S)</small>--}}
                                    {{number_format($item->tax_val,2)}}
                                </td>
                                <td style="width: 120px; text-align:right; vertical-align:middle;">
                                    {{--                                <small>(S)</small>--}}
                                    {{number_format($item->discount,2)}}
                                </td>
                                <td style="text-align:right; width:120px; padding-right:10px;">  {{number_format($item->sub_total,2)}}</td>

                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="4" style="text-align:right; padding-right:10px;">Total (Rs)
                            </td>
                            <td style="text-align:right;">{{number_format($taxTot,2)}}</td>
                            <td style="text-align:right;">{{number_format($disTot,2)}}</td>
                            <td style="text-align:right; padding-right:10px;">{{number_format($tot,2)}}</td>
                        </tr>
                        @if($sales->discount>0)
                            <tr>
                                <td colspan="6" style="text-align:right; font-weight:bold;">Order Discount (Rs)
                                </td>
                                <td style="text-align:right; padding-right:10px; font-weight:bold;">
                                    ( {{($sales->discount_val_or_per)}} ) {{number_format($sales->discount,2)}}</td>
                            </tr>
                        @endif
                        @if($sales->tax_amount>0)
                            <tr>
                                <td colspan="6" style="text-align:right; font-weight:bold;">Order tax (Rs)
                                </td>
                                <td style="text-align:right; padding-right:10px; font-weight:bold;">
                                    ( {{($sales->tax_per .'%')}} ) {{number_format($sales->tax_amount,2)}}</td>
                            </tr>
                        @endif
                        <tr>
                            <td colspan="6" style="text-align:right; font-weight:bold;">Total Amount (Rs)
                            </td>
                            <td style="text-align:right; padding-right:10px; font-weight:bold;">{{number_format($sales->invoice_grand_total,2)}}</td>
                        </tr>
                        <tr>
                            <td colspan="6" style="text-align:right; font-weight:bold;">Paid (Rs)
                            </td>
                            <td style="text-align:right; font-weight:bold;">{{0}}</td>
                        </tr>
                        <tr>
                            <td colspan="6" style="text-align:right; font-weight:bold;">Balance (Rs)
                            </td>
                            <td style="text-align:right; font-weight:bold;">{{number_format($sales->invoice_grand_total,2)}}</td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="row">
                    @if($sales->sale_note!='')
                        <div class="col-xs-6">
                            <div class="well well-sm">
                                <p>Note: </p>
                                <p>{{$sales->sale_note}} </p>
                            </div>
                        </div>
                    @endif
                    <div class="col-xs-6">
                        <div class="well well-sm">
                            <p>Created by: {{$sales->creator->name}} </p>
                            <p>Date: {{date('Y-m-d H:i:s')}}</p>
                        </div>
                    </div>
                    @if($sales->staff_note!='')
                        <div class="col-xs-6">
                            <div class="well well-sm">
                                <p>Staff Note: </p>
                                <p>{{$sales->staff_note}}</p>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
            <div class="row no-print">
                <div class="col-xs-12">
                    <div style="float: right">

                        <a class="btn btn-success" href='{{url('sales/print/'.$sales->id)}}'>
                            <i class="fa fa-file-pdf-o"></i><span class="hidden-sm hidden-xs"> PDF</span>
                        </a>

                        @if(\App\Http\Controllers\Permissions::getRolePermissions('updateAdjustment'))
                            <a class="btn btn-warning" href='{{url('sales/edit/'.$sales->id)}}'>
                                <i class="glyphicon glyphicon-edit"></i><span
                                        class="hidden-sm hidden-xs">Edit</span>
                            </a>
                        @endif
                        @if(\App\Http\Controllers\Permissions::getRolePermissions('deleteAdjustment'))
                            <a class="btn btn-danger" title="" data-toggle="popover"
                               data-content="<div style='width:150px;'><p>Are you sure?</p><a class='btn btn-danger' href='{{url('sales/delete/'.$sales->id)}}'>Yes I'm sure</a> <button class='btn bpo-close'>No</button></div>"
                               data-html="true" data-placement="top"
                               data-original-title="<b>Delete Purchase</b>">
                                <i class="fa fa-trash-o"></i> <span class="hidden-sm hidden-xs">Delete</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div><!-- /.modal -->


    </section>


    <script type="text/javascript">
        $(document).ready(function () {
            $('[data-toggle="popover"]').popover();
        })
    </script>
@endsection
