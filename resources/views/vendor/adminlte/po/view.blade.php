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
        <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url('/po/manage')}}">PO Manage</a></li>
        <li class="active">View PO</li>
    </ol>
@stop

@section('content')
    <style>
        table, th {
            text-align: center;
        }

        h4 {
            font-weight: bold;
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
                            <i class="glyphicon glyphicon-list-alt"></i> Purchase Order : {{$po->referenceCode}}
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
                            <h4 class="">{{$suppliers->company }}</h4>
                            {{$suppliers->name }}<br>{{$suppliers->address }}<br>
                            <p></p>{{$suppliers->phone }}<br>{{$locations->email}}</div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="col-xs-4 border-right">
                        <div class="col-xs-2"><i class="fa fa-3x fa-truck padding010 text-muted"></i></div>
                        <div class="col-xs-10">
                            <h4 class="">{{$locations->name}}</h4>
                            {{$locations->code}}
                            <p> {{$locations->address}}</p><br>{{$locations->telephone}}<br>{{$locations->email}}</div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-xs-4 border-left">
                        <div class="col-xs-2"><i class="fa fa-3x fa-file-text-o padding010 text-muted"></i></div>
                        <div class="col-xs-10">
                            <h4 class="">Ref.: {{$po->referenceCode}}</h4>
                            <p style="font-weight:bold;">{{$po->due_date}}</p>
                            <p style="font-weight:bold;">
                                Status: {{ \Config::get('constants.po_status_to_name.'.$po->status)}}</p>
                            <p style="font-weight:bold;">Payment Status: Pending</p>
                        </div>
                        <div class="col-xs-12 order_barcodes">
                            <span>
                                 <?php echo DNS1D::getBarcodeSVG($po->referenceCode, "C39", 1, 50); ?>
                            </span>
                            <span style="float: right">
                                     {!!  DNS2D::getBarcodeHTML(url()->current(), "QRCODE",2,2) !!}
                            </span>


                            {{--                            <img src="data:image/png;base64,{{DNS2D::getBarcodePNG(url()->current(), 'QRCODE',2,2)}}" alt="barcode" />--}}
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <!-- Table row -->
                <div class="row">
                    <div class="col-xs-12 <?= $table_responsive ?>">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Tax</th>
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

                <div class="row">
                    @if($po->approve_status)
                        <?php
                        $url = asset('storage/img/approved.png');
                        ?>
                        <div class="col-xs-4 col-xs-offset-1 align-self-end" style="float: left">
                            <img src="{{ ($url) }}" class="rounded-circle z-depth-1-half avatar-pic"
                                 alt="placeholder avatar">
                        </div>
                    @endif
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
                        {{--                        <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i>--}}
                        {{--                            Print</a>--}}


                        <div style="float: right">
                            <button type="button" onclick="showPayments({{$po->id}},'PO')" class="btn btn-success"><i
                                        class="fa fa-credit-card"></i>
                                View Payments
                            </button>
                            <a class="btn btn-success" href='{{url('po/printpo/'.$po->id)}}'>
                                <i class="fa fa-file-pdf-o"></i><span class="hidden-sm hidden-xs"> PDF</span>
                            </a>
                            @if(\App\Http\Controllers\Permissions::getRolePermissions('updateOrder'))
                                <a class="btn btn-warning" href='{{url('po/edit/'.$po->id)}}'>
                                    <i class="glyphicon glyphicon-edit"></i><span
                                            class="hidden-sm hidden-xs"> Edit</span>
                                </a>
                            @endif
                            @if(\App\Http\Controllers\Permissions::getRolePermissions('deleteOrder'))
                                <a class="btn btn-danger" title="" data-toggle="popover"
                                   data-content="<div style='width:150px;'><p>Are you sure?</p><a class='btn btn-danger' href='{{url('po/delete/'.$po->id)}}'>Yes I'm sure</a> <button class='btn bpo-close'>No</button></div>"
                                   data-html="true" data-placement="top" data-original-title="<b>Delete Purchase</b>">
                                    <i class="fa fa-trash-o"></i> <span class="hidden-sm hidden-xs">Delete</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.box -->

        <!-- remove location modal -->


        <!-- remove location modal -->
        <div class="modal fade" tabindex="-1" role="dialog" id="paymentsEditModal">

        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="paymentsShow">

        </div>

    </section>


    <script type="text/javascript">
        $(document).ready(function () {
            $('[data-toggle="popover"]').popover();
        })

        function showPayments(id, type) {
            $.ajax({
                url: '/payments/paymentsShow',
                type: 'POST',
                data: {
                    'id': id,
                    'type': type,
                    '_token': '{{@csrf_token()}}',

                }, // /converting the form data into array and sending it to server
                dataType: 'json',
                success: function (response) {
                    $('#paymentsShow').html(response.html);
                    $('#paymentsShow').modal({
                        hidden: 'true'
                    });
                },
                error: function (request, status, errorThrown) {
                }
            });
        }

    </script>
@endsection
