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
        <li><a href="{{url('/adjustment/manage')}}">Adjustment Manage</a></li>
        <li class="active">View Adjustment</li>
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
            <div class="box-header with-border">
                <h3 class="box-title">View Adjustment</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                            title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body" id="printDiv">
                <!-- info row -->

                <div class="well well-sm">
                    <div class="col-xs-6">
                        <div class="col-xs-10">
                            <p>Reference Code : {{$adjustment->reference_code}}</p>
                            <p>Date : {{$adjustment->date}}</p>
                            <p></p>
                        </div>

                    </div>


                    <div class="col-xs-6 pull-right order_barcodes ">
                        <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($adjustment->reference_code, 'C93',1, 70)}}"
                             alt="barcode"/>&nbsp;&nbsp;
                        <img src="data:image/png;base64,{{DNS2D::getBarcodePNG(url()->current(), "QRCODE",2.5,2.5)}}"
                             alt="barcode"/>


                        {{--                            <img src="data:image/png;base64,{{DNS2D::getBarcodePNG(url()->current(), 'QRCODE',2,2)}}" alt="barcode" />--}}

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
                                <th>Type</th>
                                <th>Quantity</th>
                            </tr>
                            </thead>
                            <tbody>
                            @isset($added->stockItems)
                                @foreach($added->stockItems as $key=> $p)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$p->products->name}}</td>
                                        <td>{{'Addition'}}</td>
                                        <td>{{number_format($p->qty,2)}}</td>
                                    </tr>
                                @endforeach
                            @endisset
                            <?php $i = 0;?>
                            @isset($subs->stockItems)
                                @foreach($subs->stockItems as $subsItem)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$subsItem->products->name}}</td>
                                        <td>{{'Subtraction'}}</td>
                                        <td>{{number_format($subsItem->qty,2)}}</td>
                                    </tr>
                                @endforeach
                            @endisset
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-xs-4 col-xs-offset-1 align-self-end" style="float: right">
                        <div class="well well-sm">
                            <p>Created by : {{$adjustment->creator->name}} </p>
                            <p>Date: {{$adjustment->creator->created_at}}</p>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- this row will not appear when printing -->
                <div class="row no-print">
                    <div class="col-xs-12">
                        <div style="float: right">

                            <a class="btn btn-success" onclick="window.history.back()">
                                <i class="fa fa-step-backward"></i><span class="hidden-sm hidden-xs"> back</span>
                            </a>
                            <a class="btn btn-success" onclick="print('#printDiv')">
                                <i class="fa  fa-print"></i><span class="hidden-sm hidden-xs"> Print</span>
                            </a>
                            <a class="btn btn-warning" href='{{url('adjustment/edit/'.$adjustment->id)}}'>
                                <i class="glyphicon glyphicon-edit"></i><span class="hidden-sm hidden-xs"> Edit</span>
                            </a>
                            <a class="btn btn-danger" title="" data-toggle="popover"
                               data-content="<div style='width:150px;'><p>Are you sure?</p><a class='btn btn-danger' href='{{url('adjustment/delete/'.$adjustment->id)}}'>Yes I'm sure</a> <button class='btn bpo-close'>No</button></div>"
                               data-html="true" data-placement="top" data-original-title="<b>Delete Purchase</b>">
                                <i class="fa fa-trash-o"></i> <span class="hidden-sm hidden-xs">Delete</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.box -->

        <!-- remove location modal -->


        <!-- remove location modal -->


    </section>


    <script type="text/javascript">
        $(document).ready(function () {
            $('[data-toggle="popover"]').popover();
        })
    </script>
@endsection
