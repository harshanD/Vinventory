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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<body>
<!-- Main content -->

<div class="container">

    <!-- info row -->

    <h1 align="center">{{config('adminlte.title', 'AdminLTE 2')}}</h1><br>
    <be>

        <div class="row container-fluid bg-light">
            <div class="col">
                <h4 class="">Ref.: {{$po->referenceCode}}</h4>
                <p style="font-weight:bold;">{{$po->due_date}}</p>
                <p style="font-weight:bold;">
                    Status: {{ \Config::get('constants.po_status_to_name.'.$po->status)}}</p>
                <p style="font-weight:bold;">Payment Status: Pending</p>
            </div>
            <div class="col">
                <br>
                <br>
                <span style="float: right">
            <?php
                    echo DNS1D::getBarcodeSVG($po->referenceCode, "C39", 1, 50); ?>
                                        </span>

                <span class="float-right">
{{--                                                 {!!  DNS2D::getBarcodeHTML(url  ()->current(), "QRCODE",2,2) !!}--}}
                                                </span>
            </div>
        </div>
        <br>
        <div class="row container-fluid">
            <div class="col">

                <div class="col-xs-10">
                    <p>To</p>

                    <h4 class="">{{$suppliers->company }}</h4>
                    {{$suppliers->name }}<br>{{$suppliers->address }}<br>
                    <p></p>{{$suppliers->phone }}<br>{{$locations->email}}</div>
                <div class="clearfix"></div>
            </div>

            <div class="col">
                <div class="col-xs-10">
                    <p>From </p>
                    <h4 class="">{{$locations->name}}</h4>
                    {{$locations->code}}
                    <p> {{$locations->address}}</p><br>{{$locations->telephone}}<br>{{$locations->email}}</div>
                <div class="clearfix"></div>
            </div>
        </div>
        <br>
        <!-- Table row -->
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table ">

                    <tr class="bg-light">
                        <th>No</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Tax</th>
                        <th>Subtotal</th>
                    </tr>

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
                    <tr style="font-weight: bold">
                        <td colspan="4" style="text-align: right">Total (Rs)</td>
                        <td style="text-align: right">{{number_format($po->tax,2)}}</td>
                        <td style="text-align: right">{{number_format($po->grand_total,2)}}</td>
                    </tr>
                    <tr style="font-weight: bold">
                        <td style="text-align: right" colspan="5">Total Amount (Rs)</td>
                        <td style="text-align: right">{{number_format($po->grand_total,2)}}</td>
                    </tr>
                    <tr style="font-weight: bold">
                        <td style="text-align: right" colspan="5">Paid (Rs)</td>
                        <td style="text-align: right">{{number_format(00,2)}}</td>
                    </tr>
                    <tr style="font-weight: bold">
                        <td style="text-align: right" colspan="5">Balance (Rs)</td>
                        <td style="text-align: right">{{number_format($po->grand_total,2)}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->


        <br>
        <div class="float-right">
            <p>Ordered by : {{$po->creator->name}} </p><br><br>
            <p>...............................................</p>
            <p>Stamp and Signature</p>
        </div>

        <!-- /.col -->

        <!-- /.row -->


        <!-- /.box -->

        <!-- remove location modal -->


        <!-- remove location modal -->

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