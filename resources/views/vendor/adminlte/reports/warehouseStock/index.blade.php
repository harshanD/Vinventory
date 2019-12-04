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
        <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Manage Suppliers</li>
    </ol>
@stop

@section('content')
    <!-- Main content -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script src="{{ asset('custom/canvas/html2canvas.min.js') }}"></script>

    <style>
        .avatar-pic {
            width: 100px;
            height: 100px;
        }
    </style>

    <section class="content">
        <!-- Default box -->

        <div class="box">

            <div class="box-header with-border">
                <h3 class="box-title">Warehouse Stock Chart ( {{ $warehouse}} )</h3>

                <div class="box-tools pull-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown"
                                aria-expanded="true">
                            <i class="fa fa-wrench"></i></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/reports/warehouse_stock') }}"><i class="fa fa-building-o"></i>All
                                    WareHouse</a></li>
                            @foreach($warehouseList as $ware)
                                <li><a href="{{ url('/reports/warehouse_stock/'.$ware->id) }}"><i
                                                class="fa fa-building"></i>{{ $ware->name }}</a>
                                </li>
                            @endforeach
                            <li class="divider"></li>
                            <li><a style="cursor: pointer" onclick="getImage()"><i class="fa fa-file-image-o"></i>Save As
                                    Image</a></li>
                            {{--                            <li class="divider"></li>--}}

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

                    <div class="small-box padding1010 col-sm-6" style="background-color: #5D96CD">
                        <div class="inner clearfix">
                            <a style="text-align: center;color: white">
                                <h3>{{$data['itemCount']}}</h3>

                                <p>Total Items</p>
                            </a>
                        </div>
                    </div>
                    <div class="small-box padding1010 col-sm-6" style="background-color: #89E676">
                        <div class="inner clearfix">
                            <a style="text-align: center;color: white">
                                <h3>{{$data['totalQty']}}</h3>

                                <p>Total Quantity</p>
                            </a>
                        </div>
                    </div>
                </div>
                <div id="sales-donut"></div>
                <div id="copyDiv" class="image-link">
                </div>
            </div>
        </div>
    </section>

    <script>

        var imageDivId = 'capture';
        var imageSaveName = 'Warehouse_Stock_chart_({{$warehouse}})_';


        /*       new Morris.Line({
                   // ID of the element in which to draw the chart.
                   element: 'myfirstchart',
                   // Chart data records -- each entry in this array corresponds to a point on
                   // the chart.
                   data: [
                       { year: '2008', value: 20 },
                       { year: '2009', value: 10 },
                       { year: '2010', value: 5 },
                       { year: '2011', value: 5 },
                       { year: '2012', value: 20 }
                   ],
                   // The name of the data record attribute that contains x-values.
                   xkey: 'year',
                   // A list of names of data record attributes that contain y-values.
                   ykeys: ['value'],
                   // Labels for the ykeys -- will be displayed when you hover over the
                   // chart.
                   labels: ['Value']
               });*/
        Morris.Donut({
            element: 'sales-donut',
            resize: true,
            data: [
                {label: "Stock Value By Price", color: '#5D96CD', value: '{{$data['stockValueByPrice']}}'},
                {label: "Stock Value By Cost", color: '#171719', value: '{{$data['stockValueByCost']}}'},
                {label: "Profit Estimate", color: '#89E676', value: '{{$data['profitEstimate']}}'}
            ]
        });


    </script>


@stop
