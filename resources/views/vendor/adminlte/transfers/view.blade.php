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
    <section>

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
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped order-table">
                                <thead>
                                <tr>
                                    <th style="text-align:center; vertical-align:middle;">No.</th>
                                    <th style="vertical-align:middle;">Product</th>
                                    <th style="text-align:center; vertical-align:middle;">Quantity</th>
                                    <th style="text-align:center; vertical-align:middle;">Unit Cost</th>
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
                            <div class="col-xs-12">
                            </div>
                            <div class="col-xs-4 pull-left">
                                <p>Created by: {{$transfers->creator->name}} </p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <hr>
                                <p>Stamp &amp; Signature</p>
                            </div>
                            <div class="col-xs-4 col-xs-offset-1 pull-right">
                                <p>Received by: </p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <hr>
                                <p>Stamp &amp; Signature</p>
                            </div>
                        </div>
                        <div class="buttons">
                            <div class="btn-group btn-group-justified">
                                <div class="btn-group">
                                    <a href="https://sma.tecdiary.com/admin/transfers/email/1" data-toggle="modal"
                                       data-target="#myModal2" class="tip btn btn-primary" title=""
                                       data-original-title="Email">
                                        <i class="fa fa-envelope-o"></i>
                                        <span class="hidden-sm hidden-xs">Email</span>
                                    </a>
                                </div>
                                <div class="btn-group">
                                    <a href="https://sma.tecdiary.com/admin/transfers/pdf/1" class="tip btn btn-primary"
                                       title="" data-original-title="Download as PDF">
                                        <i class="fa fa-download"></i>
                                        <span class="hidden-sm hidden-xs">PDF</span>
                                    </a>
                                </div>
                                <div class="btn-group">
                                    <a href="https://sma.tecdiary.com/admin/transfers/edit/1"
                                       class="tip btn btn-warning sledit" title="" data-original-title="Edit">
                                        <i class="fa fa-edit"></i>
                                        <span class="hidden-sm hidden-xs">Edit</span>
                                    </a>
                                </div>
                                <div class="btn-group">
                                    <a href="#" class="tip btn btn-danger bpo" title=""
                                       data-content="<div style='width:150px;'><p>Are you sure?</p><a class='btn btn-danger' href='https://sma.tecdiary.com/admin/transfers/delete/1'>Yes I'm sure</a> <button class='btn bpo-close'>No</button></div>"
                                       data-html="true" data-placement="top" data-original-title="<b>Delete</b>">
                                        <i class="fa fa-trash-o"></i>
                                        <span class="hidden-sm hidden-xs">Delete</span>
                                    </a>
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
