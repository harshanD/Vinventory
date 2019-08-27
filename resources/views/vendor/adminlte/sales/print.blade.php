<!doctype html>

<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Purchase Order</title>
</head>
{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>--}}
{{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />--}}
{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>--}}
{{--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"/>--}}
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
      integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<style>
    .page-break {
        page-break-after: always;
    }
</style>
<body>
<!-- Main content -->

<div class="container">

    <!-- info row -->

    <h2 align="center">{{config('adminlte.title', 'AdminLTE 2')}} - Invoice</h2><br>

    <div class="box">
        <div class="box-header with-border">

            <div class="well well-sm">
                <div class="col-xs-4 border-right">
                    <div class="col-xs-2"><i class="fa fa-3x fa-user padding010 text-muted"></i></div>
                    <div class="col-xs-10">
                        <h4 class="">{{$customer->name}}</h4>
                        {{$customer->address}}<br><br>{{$customer->phone}}<br>{{$customer->email}}
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="col-xs-4 border-right">
                    <div class="col-xs-2"><i class="fa fa-3x fa-building padding010 text-muted"></i></div>
                    <div class="col-xs-10">
                        <h4 class="">{{$biller->name}}</h4>
                        {{$biller->address}} <br>
                        <p><br></p>{{$biller->phone}}<br>{{$biller->email}}</div>
                    <div class="clearfix"></div>
                </div>
                <div class="col-xs-4">
                    <div class="col-xs-2"><i class="fa fa-3x fa-building-o padding010 text-muted"></i></div>
                    <div class="col-xs-10">
                        <h4 class="">{{$location->name}}</h4>

                        <p>{{$location->address}}</p><br>{{$location->phone}}<br>{{$location->email}}</div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
            <div class="clearfix"></div>
            <div class="col-xs-7 pull-right">
                <div class="col-xs-12 text-right order_barcodes">
                    <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($sales->invoice_code, 'C93',1, 70)}}"
                         alt="barcode"/>&nbsp;&nbsp;
                    <img src="data:image/png;base64,{{DNS2D::getBarcodePNG(url()->current(), "QRCODE",2.5,2.5)}}"
                         alt="barcode"/></div>
                <div class="clearfix"></div>
            </div>
            <div class="col-xs-5">
                <div class="col-xs-2"><i class="fa fa-3x fa-file-text-o padding010 text-muted"></i></div>
                <div class="col-xs-10">
                    <h4 class="">Reference: {{$sales->invoice_code}}</h4>
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
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped order-table">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Description (Code)</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th style="text-align:center; vertical-align:middle;">Tax</th>
                        <th style="text-align:center; vertical-align:middle;">Discount</th>
                        <th style="">Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <?php $tot = 0; $incr = 0;$taxTot = 0;$disTot = 0; ?>
                        @foreach($sales->invoiceItems as $item)
                            <?php $tot += $item->sub_total;
                            $taxTot += $item->tax_val;
                            $disTot += $item->discount;
                            ?>
                            <td style="text-align:center; vertical-align:middle;">{{++$incr}}</td>
                            <td style="text-align:left">
                                {{$item->products->name}} [ {{$item->products->item_code}} ]
                            </td>
                            <td style="text-align:center; vertical-align:middle;"> {{$item->qty}} </td>

                            <td style="text-align:right;padding-right:10px;">
                                {{number_format($item->selling_price,2)}}
                            </td>
                            <td style="text-align:right; vertical-align:middle;">
                                {{--                                <small>(S)</small>--}}
                                {{number_format($item->tax_val,2)}}
                            </td>
                            <td style="text-align:right; vertical-align:middle;">
                                {{--                                <small>(S)</small>--}}
                                {{number_format($item->discount,2)}}
                            </td>
                            <td style="text-align:right;">  {{number_format($item->sub_total,2)}}</td>
                    </tr>
                    @endforeach

                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="4" style="text-align:right;">Total (Rs)
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
                                ({{($sales->discount_val_or_per)}}) {{number_format($sales->discount,2)}}</td>
                        </tr>
                    @endif
                    @if($sales->tax_amount>0)
                        <tr>
                            <td colspan="6" style="text-align:right; font-weight:bold;">Order tax (Rs)
                            </td>
                            <td style="text-align:right; padding-right:10px; font-weight:bold;">
                                ({{($sales->tax_per .'%')}}) {{number_format($sales->tax_amount,2)}}</td>
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
                        <td style="text-align:right; font-weight:bold;">{{number_format(0,2)}}</td>
                    </tr>
                    <tr>
                        <td colspan="6" style="text-align:right; font-weight:bold;">Balance (Rs)
                        </td>
                        <td style="text-align:right; font-weight:bold;">{{number_format($sales->invoice_grand_total,2)}}</td>
                    </tr>
                    </tfoot>

                </table>
            </div>


        </div>
        <div class="page-break"></div>
        <div class="row">
            <div class="col-xs-12">
                @if($sales->sale_note!='')
                    <div class="well well-sm">
                        <p>Note: </p>
                        <p>{{$sales->sale_note}} </p>
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="col-xs-4 pull-left">
                    <p>Seller: {{$biller->name}} </p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <hr>
                    <p>Stamp &amp; Signature</p>
                </div>
                <div class="col-xs-4 col-xs-offset-1 pull-right">
                    <p>Customer : {{$customer->name}}</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <hr>
                    <p>Stamp &amp; Signature</p>
                </div>
            </div>
        </div>

        {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>--}}

        {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>--}}
        {{--<link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/AdminLTE.min.css') }}">--}}
        {{--<link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">--}}
        <style>
            table, th {
                text-align: center;
            }

            /*h4 {*/
            /*    font-weight: bold;*/
            /*}*/

            table td, table th {
                border: 1px solid #c2c7bd;
            }
        </style>
    </div>
</html>
{{--<script src="{{ asset('vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>--}}