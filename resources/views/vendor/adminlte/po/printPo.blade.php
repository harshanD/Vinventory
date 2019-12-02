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
<body>
<!-- Main content -->

<div class="container">

    <!-- info row -->

    <h1 align="center">{{config('adminlte.title', 'AdminLTE 2')}}- Purchase Order</h1><br>

    <div class="box">
        <div class="box-header with-border">

            <div class="well well-sm">
                <div class="row bold">
                    <div class="col-xs-4">Date: {{$po->due_date}}
                        <br>
                        <p style="font-weight:bold;">
                            Status: {{ \Config::get('constants.po_status_to_name.'.$po->status)}}</p>
                        <p style="font-weight:bold;">Payment Status: Pending</p>
                        <br>
                        Reference: {{$po->referenceCode}}</div>
                    <div class="col-xs-6 pull-right text-right order_barcodes">
                        <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($po->referenceCode, 'C93',1, 70)}}"
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
                    <h3 style="margin-top:10px;">{{$suppliers->company }}
                        ( {{$suppliers->name}} )</h3>
                    <p></p>
                    <p>{{$suppliers->address }}</p>
                    <p></p>
                    <p>{{$suppliers->phone }}<br>{{$suppliers->email}}</p></div>
                <div class="col-xs-6">
                    From:
                    <h3 style="margin-top:10px;">{{$locations->name }}
                        ( {{$locations->code }} )</h3>
                    <p></p>
                    <p>{{$locations->address }}</p>
                    <p></p>
                    <p>{{$locations->telephone }}<br>{{$locations->email}}</p>
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

                    @foreach($po->poDetails as $key => $p)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$p->product->name}}( {{$p->product->item_code }} )</td>
                            <td>{{$p->qty}}</td>
                            <td style="text-align: right">{{number_format(($p->cost_price),2)}}</td>
                            <td style="text-align: right">{{number_format($p->tax_per,2)}}</td>
                            <td style="text-align: right">{{number_format($p->sub_total,2)}}</td>
                        </tr>
                    @endforeach

                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="4" style="text-align:right;">Total (Rs)
                        </td>
                        <td style="text-align:right;">
                            {{number_format($po->tax,2)}}
                        </td>
                        <td style="text-align:right;">
                            {{number_format($po->grand_total,2)}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align:right; font-weight:bold;">Total Amount (Rs)
                        </td>
                        <td style="text-align:right; font-weight:bold;">  {{number_format($po->grand_total,2)}}</td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align:right; font-weight:bold;">Paid (Rs)
                        </td>
                        <td style="text-align:right; font-weight:bold;">  {{number_format(00,2)}}</td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align:right; font-weight:bold;">Balance (Rs)
                        </td>
                        <td style="text-align:right; font-weight:bold;">{{number_format($po->grand_total,2)}}</td>
                    </tr>

                    </tfoot>
                </table>
            </div>
            <div class="row">
                <div class="col-xs-12">
                </div>
                <div class="col-xs-4  pull-right">
                    <p>Created by: {{$po->creator->name}} </p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <hr>
                    <p>Stamp &amp; Signature</p>
                </div>
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
</body>
</html>
{{--<script src="{{ asset('vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>--}}
