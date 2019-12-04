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
    <script src="{{ asset('custom/canvas/html2canvas.min.js') }}"></script>
    <section class="content">
        <!-- Default box -->

        <div class="box">

            <div class="box-header with-border">
                <h3 class="box-title">Product Quantity Alerts ( {{ $warehouse}} )</h3>

                <div class="box-tools pull-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown"
                                aria-expanded="true">
                            <i class="fa fa-wrench"></i></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/reports/quantity_alerts') }}"><i class="fa fa-building-o"></i>All
                                    WareHouse</a></li>
                            @foreach($warehouseList as $ware)
                                <li><a href="{{ url('/reports/quantity_alerts/'.$ware->id) }}"><i
                                                class="fa fa-building"></i>{{ $ware->name }}</a>
                                </li>
                            @endforeach
                            <li class="divider"></li>
                            <li><a style="cursor: pointer" onclick="getImage()"><i class="fa fa-file-image-o"></i>Save As
                                    Image</a></li>
                            <li><a style="cursor: pointer" onclick="getXls()"><i class="fa fa-file-excel-o"></i>Save As
                                    xls</a></li>

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
                    <div class="<?= $table_responsive ?>">
                        <table id="manageTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th class="noExl">Image</th>
                                <th>Product Code</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Alert Quantity</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php

                            ?>
                            @foreach($data as $a)
                                <tr>
                                    <td class="noExl">{!!  $a['image']!!}</td>
                                    <td>{{$a['code']}}</td>
                                    <td>{{$a['name']}}</td>
                                    <td>{{$a['qty']}}</td>
                                    <td>{{$a['alertQuantity']}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
        {{--        <a  href="http://vinventory.offilne/storage/products/dISa5zosMaEf0Nar3YQcVL7kaXPPo2WTUGvsZa1R.jpeg"--}}
        {{--           class="image-link">--}}
        {{--            <img style="width: 100px;height: 100px" src="http://vinventory.offilne/storage/products/dISa5zosMaEf0Nar3YQcVL7kaXPPo2WTUGvsZa1R.jpeg" alt="">--}}
        {{--        </a>--}}
    </section>

    <script>

        var imageDivId = 'capture';
        var imageSaveName = 'Product_Quantity_Alerts_({{$warehouse}})_';

        function getXls() {
            $("#manageTable").table2excel({
                exclude: ".noExl",
                name: "Worksheet Name",
                filename: imageSaveName,
                fileext: ".xls",
                exclude_img: false,
                exclude_links: true,
                exclude_inputs: true
            });
        }


        var manageTable;

        $(document).ready(function () {
            manageTable = $('#manageTable').DataTable({
                "columns": [
                    {"orderable": false},
                    null,
                    null,
                    null,
                    null,
                ],
                columnDefs: [
                    {
                        "targets": [0, 3, 4], // your case first column
                        "className": "text-center",
                    },
                ],
            });
        })

    </script>


@stop
