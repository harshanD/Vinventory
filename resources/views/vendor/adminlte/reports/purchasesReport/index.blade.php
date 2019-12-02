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
    <section class="content">
        <!-- Default box -->

        <div class="box">

            <div class="box-header with-border">
                <h3 class="box-title">Purchases Report</h3>

                <div class="box-tools pull-right">

                    <button class="btn btn-box-tool" type="button" data-toggle="collapse"
                            data-target="#multiCollapseExample1" aria-expanded="false"
                            aria-controls="multiCollapseExample1"><i class="fa fa-fw fa-filter"></i></button>
                    <div class="btn-group">
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
                    <form action="purchases" method="get">
                        <div class="row collapse multi-collapse" id="multiCollapseExample1">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="suggest_product">Product</label>
                                    <select class="form-control select2" id="product" name="product">
                                        <option value="0">Select Product</option>
                                        @foreach($products as $pro)
                                            <option
                                                <?= (app('request')->input('product') == $pro->id) ? 'selected' : ''; ?> value="{{$pro->id}}">{{$pro->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="suggest_product">Reference No</label>
                                    <input class="form-control" type="text" name="ref" id="ref"
                                           value="{{app('request')->input('ref') }}">
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="suggest_product">Created By</label>
                                    <select class="form-control select2" id="createdUser" name="createdUser">
                                        <option value="0">Select User</option>
                                        @foreach($soldUsers as $user)
                                            <option
                                                <?= (app('request')->input('createdUser') == $user->creator->id) ? 'selected' : ''; ?> value="{{$user->creator->id}}">{{$user->creator->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="suggest_product">Supplier</label>
                                    <select class="form-control select2" id="supplier" name="supplier">
                                        <option value="0">Select Supplier</option>
                                        @foreach($suppliers as $sup)
                                            <option
                                                <?= (app('request')->input('supplier') == $sup->id) ? 'selected' : ''; ?> value="{{$sup->id}}">{{$sup->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="suggest_product">Warehouse</label>
                                    <select class="form-control select2" id="warehouse" name="warehouse">
                                        <option value="0">Select Warehouse</option>
                                        @foreach($warehouses as $ware)
                                            <option
                                                <?= (app('request')->input('warehouse') == $ware->id) ? 'selected' : ''; ?> value="{{$ware->id}}">{{$ware->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="suggest_product">From Date</label>
                                    <input type="text" name="from" value="{{app('request')->input('from')}}"
                                           class="form-control ui-autocomplete-input input-xs"
                                           id="datepicker"
                                           autocomplete="off">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="suggest_product">To Date</label>
                                    <input type="text" name="to" value="{{app('request')->input('to')}}"
                                           class="form-control ui-autocomplete-input input-xs"
                                           id="datepicker1"
                                           autocomplete="off">
                                </div>
                            </div>
                            <div class="col-sm-4" style="float: right">
                                <div class="form-group">
                                    <br>&nbsp;
                                    <button class="btn btn-primary" id="submit" name="submit" type="submit">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="<?= $table_responsive ?>">
                        <table id="manageTable" class="table table-bordered table-striped table table-hover">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Reference No</th>
                                <th>Location</th>
                                <th>Supplier</th>
                                <th>Product(Qty)</th>
                                <th>Grand Total</th>
                                <th>Paid</th>
                                <th>Balance</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($filteredData as $filData)
                                <?php $ss = $filData->poDetails;

                                switch ($filData->status):
                                    case 1:
                                        $SaleStatus = '<span class="label label-warning">pending</span>';
                                        break;
                                    case 2:
                                        $SaleStatus = '<span class="label label-success">Completed</span>';
                                        break;
                                    default:
                                        $SaleStatus = '<span class="label label-danger">Nothing</span>';
                                        break;
                                endswitch;
                                ?>
                                <tr onclick="window.location='/po/view/{{$filData->id  }}'" style="cursor: pointer">
                                    <th>{{$filData->due_date}}</th>
                                    <th>{{$filData->referenceCode}}</th>
                                    <th>{{$filData->locations->name}}</th>
                                    <th>{{$filData->suppliers->name}}</th>
                                    <th>
                                        @foreach($ss as $s)
                                            @if($s->product->id==app('request')->input('product'))
                                                <?= '<strong>' . ($s->product->name) . '</strong>' . '(' . $s->qty . ')' . '<br>'?>
                                            @else
                                                <?= ($s->product->name) . '(' . $s->qty . ')' . '<br>'?>
                                            @endif
                                        @endforeach
                                    </th>
                                    <th>{{number_format($filData->grand_total,2)}}</th>
                                    <th>{{number_format($filData->paid,2)}}</th>
                                    <th>{{number_format($filData->grand_total-$filData->paid,2)}}</th>
                                    <th>{!! $SaleStatus !!}</th>

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
        // $('#multiCollapseExample1').collapse({
        //     toggle: false
        // })
        var imageDivId = 'capture';
        var imageSaveName = 'purchases_';

        function getXls() {
            $("#manageTable").table2excel({
                exclude: ".noExl",
                name: "Worksheet Name",
                filename: imageSaveName + '{{date('Y-m-d H:i:s')}}',
                fileext: ".xls",
                exclude_img: false,
                exclude_links: true,
                exclude_inputs: true
            });
        }


        var manageTable;

        $(document).ready(function () {
            $('#manageTable').DataTable({
                "order": [[0, "desc"]],
                columnDefs: [
                    {
                        "targets": [5, 6, 7], // your case first column
                        "className": "text-right",
                    }, {
                        "targets": [8], // your case first column
                        "className": "text-center",
                    }, {
                        "targets": [4, 8], // your case first column
                        "orderable": false
                    }
                ],
            });
        });

        $('#btn1').click(function () {
            $('.collapse').hide();
            // $('#demo1').hide();
            $('#demo').show();
        });

    </script>


@stop
