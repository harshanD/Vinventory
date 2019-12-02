<?php
/**
 * Created by PhpStorm.
 * User: harshan
 * Date: 7/26/19
 * Time: 11:00 PM
 */
?>
@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <ol class="breadcrumb">
        <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Manage Suppliers</li>
    </ol>
@stop

@section('content')
    <script src="{{ asset('custom/canvas/html2canvas.min.js') }}"></script>
    <style>
        /* calendar */
        table.calendar {
            border-left: 1px solid #999;
        }

        tr.calendar-row {
        }

        td.calendar-day {
            min-height: 80px;
            font-size: 11px;
            position: relative;
        }

        * html div.calendar-day {
            height: 80px;
        }

        td.calendar-day:hover {
            background: #eceff5;
        }

        td.calendar-day-np {
            background: #eee;
            min-height: 80px;
        }

        * html div.calendar-day-np {
            height: 80px;
        }

        td.calendar-day-head {
            background: #ccc;
            font-weight: bold;
            text-align: center;
            width: 120px;
            padding: 5px;
            border-bottom: 1px solid #999;
            border-top: 1px solid #999;
            border-right: 1px solid #999;
        }

        div.day-number {
            background: #999;
            padding: 5px;
            color: #fff;
            font-weight: bold;
            float: right;
            margin: -5px -5px 0 0;
            width: 20px;
            text-align: center;
        }

        /* shared */
        td.calendar-day, td.calendar-day-np {
            width: 120px;
            padding: 5px;
            border-bottom: 1px solid #999;
            border-right: 1px solid #999;
        }
    </style>
    <section class="content">
        <!-- Default box -->

        <div class="box">

            <div class="box-header with-border">
                <h3 class="box-title">Daily Sales Report</h3>

                <div class="box-tools pull-right">
                    <div class="btn-group">
                        <button class="btn btn-box-tool" type="button" data-toggle="collapse"
                                data-target="#multiCollapseExample1" aria-expanded="false"
                                aria-controls="multiCollapseExample1"><i class="fa fa-fw fa-filter"></i></button>
                        <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown"
                                aria-expanded="true">
                            <i class="fa fa-wrench"></i></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a style="cursor: pointer" onclick="getImage()"><i class="fa fa-file-image-o"></i>Save
                                    As
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
                    <div class="row collapse multi-collapse" id="multiCollapseExample1">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="suggest_product">Month</label> <input type="text" name="month"
                                                                                  value="{{$yearMonth}}"
                                                                                  class="form-control input-xs"
                                                                                  id="monthpicker"
                                                                                  autocomplete="off">
                                <input type="hidden" name="product" value="" id="report_product_id" class="input-xs">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <br>&nbsp;
                                <button class="btn btn-primary" id="search" data-toggle="modal"
                                        data-target="#addSupplierModal">Submit
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="<?= $table_responsive ?>" id="drawTable">
                        {!! $table !!}

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
        $('.row2').collapse({
            toggle: false
        })
        var imageDivId = 'capture';
        var imageSaveName = 'dailySales_()_';

        function getXls() {
            $("#manageTable").table2excel({
                exclude: ".noExl",
                name: "Worksheet Name",
                filename: imageSaveName,
                fileext: ".xls",
                exclude_img: false,
                exclude_links: true,
                exclude_inputs: false
            });
        }

        $(document).ready(function () {
            $("#search").click(function () {
                $('#drawTable').html('')
                $.ajax('/reports/daily_sales/' + $('#monthpicker').val(),
                    {
                        type: 'post',  // http method
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },  // data to submit
                        success: function (data, status, xhr) {

                            $('#drawTable').html(JSON.parse(data))
                        },
                        error: function (jqXhr, textStatus, errorMessage) {
                            $('p').append('Error' + errorMessage);
                        }
                    });
            });
        })

    </script>
@stop
