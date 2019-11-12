@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Home</h1>
@stop

@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        @if(!\Illuminate\Support\Facades\Auth::user()->hasRole('Guest'))
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Dashboard</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                                title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="card-body">
                        <div class="row">
                            @if(\App\Http\Controllers\Permissions::getRolePermissions('viewUser'))
                                <div class="col-sm-4 col-lg-3 col-md-6 col-xm-2">
                                    <div class="square-service-block">
                                        <a href="{{url('/user/manage')}}">
                                            <button class="btn btn-default">
                                                <div class="ssb-icon">
                                                    <div class="incon-box">
                                                        <i class="fa fa-users" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                                <h2 class="ssb-title">User</h2>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if(\App\Http\Controllers\Permissions::getRolePermissions('viewAdjustment'))
                                <div class="col-sm-4 col-lg-3 col-md-6 col-xm-2">
                                    <div class="square-service-block">
                                        <a href="{{url('/adjustment/manage')}}">
                                            <button href="#" class="btn btn-default">
                                                <div class="ssb-icon">
                                                    <div class="incon-box">
                                                        <i class="fa fa-filter " aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                                <h2 class="ssb-title">Adjustment</h2>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if(\App\Http\Controllers\Permissions::getRolePermissions('viewProduct'))
                                {{--col-lg-3 col-md-6 col-xm-2--}}

                                <div class="col-sm-4 col-lg-3 col-md-6 col-xm-2">
                                    <div class="square-service-block">
                                        <a href="{{url('/products')}}">
                                            <button href="#" class="btn btn-default">
                                                <div class="ssb-icon">
                                                    <div class="incon-box">
                                                        <i class="fa fa-cubes" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                                <h2 class="ssb-title">Product</h2>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if(\App\Http\Controllers\Permissions::getRolePermissions('viewWarehouse'))
                                <div class="col-sm-4 col-lg-3 col-md-6 col-xm-2">
                                    <div class="square-service-block">
                                        <a href="{{url('/locations')}}">
                                            <button href="#" class="btn btn-default">
                                                <div class="ssb-icon">
                                                    <div class="incon-box">
                                                        <i class="fa fa-building-o" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                                <h2 class="ssb-title">Warehouse</h2>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if(\App\Http\Controllers\Permissions::getRolePermissions('viewSale'))
                                <div class="col-sm-4 col-lg-3 col-md-6 col-xm-2">
                                    <div class="square-service-block">
                                        <a href="{{url('/sales/manage')}}">
                                            <button href="#" class="btn btn-default">
                                                <div class="ssb-icon">
                                                    <div class="incon-box">
                                                        <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                                <h2 class="ssb-title">Sales</h2>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if(\App\Http\Controllers\Permissions::getRolePermissions('viewOrder'))
                                <div class="col-sm-4 col-lg-3 col-md-6 col-xm-2">
                                    <div class="square-service-block">
                                        <a href="{{url('/po/manage')}}">
                                            <button href="#" class="btn btn-default">
                                                <div class="ssb-icon">
                                                    <div class="incon-box">
                                                        <i class="fa fa-credit-card" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                                <h2 class="ssb-title">PO</h2>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if(\App\Http\Controllers\Permissions::getRolePermissions('viewTransfer'))
                                <div class="col-sm-4 col-lg-3 col-md-6 col-xm-2">
                                    <div class="square-service-block">
                                        <a href="{{url('/transfer/manage')}}">
                                            <button href="#" class="btn btn-default">
                                                <div class="ssb-icon">
                                                    <div class="incon-box">
                                                        <i class="fa fa-random" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                                <h2 class="ssb-title">Transfers</h2>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if(\App\Http\Controllers\Permissions::getRolePermissions('viewReturns'))
                                <div class="col-sm-4 col-lg-3 col-md-6 col-xm-2">
                                    <div class="square-service-block">
                                        <a href="{{url('/returns/manage')}}">
                                            <button href="#" class="btn btn-default">
                                                <div class="ssb-icon">
                                                    <div class="incon-box">
                                                        <i class="fa fa-arrow-circle-down" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                                <h2 class="ssb-title">Returns</h2>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if(\App\Http\Controllers\Permissions::getRolePermissions('viewBiller'))
                                <div class="col-sm-4 col-lg-3 col-md-6 col-xm-2">
                                    <div class="square-service-block">
                                        <a href="{{url('/biller/manage')}}">
                                            <button href="#" class="btn btn-default">
                                                <div class="ssb-icon">
                                                    <div class="incon-box">
                                                        <i class="fa fa-users" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                                <h2 class="ssb-title">Billers</h2>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if(\App\Http\Controllers\Permissions::getRolePermissions('viewCustomer'))
                                <div class="col-sm-4 col-lg-3 col-md-6 col-xm-2">
                                    <div class="square-service-block">
                                        <a href="{{url('/customer/manage')}}">
                                            <button href="#" class="btn btn-default">
                                                <div class="ssb-icon">
                                                    <div class="incon-box">
                                                        <i class="fa fa-align-center" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                                <h2 class="ssb-title">Customers</h2>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if(\App\Http\Controllers\Permissions::getRolePermissions('viewSupplier'))
                                <div class="col-sm-4 col-lg-3 col-md-6 col-xm-2">
                                    <div class="square-service-block">
                                        <a href="{{url('/supplier')}}">
                                            <button href="#" class="btn btn-default">
                                                <div class="ssb-icon">
                                                    <div class="incon-box">
                                                        <i class="fa fa-truck" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                                <h2 class="ssb-title">Supplier</h2>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if(\App\Http\Controllers\Permissions::getRolePermissions('viewCategory'))
                                <div class="col-sm-4 col-lg-3 col-md-6 col-xm-2">
                                    <div class="square-service-block">
                                        <a href="{{url('/categories')}}">
                                            <button href="#" class="btn btn-default">
                                                <div class="ssb-icon">
                                                    <div class="incon-box">
                                                        <i class="fa fa-folder-open" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                                <h2 class="ssb-title">Categories</h2>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                @else
                    <div class="alert alert-warning alert-dismissible f" role="alert">
                        <strong>Hi {{ \Illuminate\Support\Facades\Auth::user()->name }} !</strong> Please Contact System
                        Administrator.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            </div>

            {{--    TOP 5--}}
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Latest Five</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                                title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                {{--                    <div class="card-body">--}}
                {{--                        <div class="row">--}}
                <!-- Custom Tabs -->
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab">Sales</a></li>
                            <li><a href="#tab_2" data-toggle="tab">Purchases</a></li>
                            <li><a href="#tab_3" data-toggle="tab">Transfers</a></li>
                            <li><a href="#tab_4" data-toggle="tab">Customers</a></li>
                            <li><a href="#tab_5" data-toggle="tab">Suppliers</a></li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    Actions <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a>
                                    </li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another
                                            action</a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something
                                            else
                                            here</a></li>
                                    <li role="presentation" class="divider"></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated
                                            link</a></li>
                                </ul>
                            </li>
                            <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <table class="table table-hover">
                                    <thead>
                                    <th align="center">#</th>
                                    <th align="center">Date</th>
                                    <th align="center">Reference No</th>
                                    <th align="center">Customer</th>
                                    <th align="center">Status</th>
                                    <th align="center">Total</th>
                                    <th align="center">Payment Status</th>
                                    <th align="center">paid</th>
                                    </thead>
                                    @foreach($sales as $sale)
                                        <tr>
                                            <td>{{ $loop->iteration}}</td>
                                            <td>{{ $sale['invoice_date'] }}</td>
                                            <td>{{ $sale['invoice_code'] }}</td>
                                            <td>{{ $sale['cus_name'] }}</td>

                                            <?php
                                            switch ($sale['sales_status']):
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

                                            <td align="center">{!!$SaleStatus !!}</td>
                                            <td align="right">{{ $sale['invoice_grand_total'] }}</td>

                                            <?php
                                            switch ($sale['payment_status']):
                                                case 1:
                                                    $payStatus = '<span class="label label-warning">pending</span>';
                                                    break;
                                                case 2:
                                                    $payStatus = '<span class="label label-warning">Due</span>';
                                                    break;
                                                case 3:
                                                    $payStatus = '<span class="label label-warning">Partial</span>';
                                                    break;
                                                case 4:
                                                    $payStatus = '<span class="label label-success">Paid</span>';
                                                    break;
                                                case 5:
                                                    $payStatus = '<span class="label label-danger">Over Paid</span>';
                                                    break;
                                                default:
                                                    $payStatus = '<span class="label label-danger">Nothing</span>';
                                                    break;
                                            endswitch;
                                            ?>

                                            <td align="center">{!! $payStatus !!}</td>
                                            <td align="right">{{ $sale['paid'] }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_2">
                                <table class="table table-hover">
                                    <thead>
                                    <th align="center">#</th>
                                    <th align="center">Date</th>
                                    <th align="center">Reference No</th>
                                    <th align="center">Supplier</th>
                                    <th align="center">Status</th>
                                    <th align="center">Total</th>
                                    </thead>
                                    @foreach($purchaces as $purchace)
                                        <tr>
                                            <td>{{ $loop->iteration}}</td>
                                            <td>{{ $purchace['date'] }}</td>
                                            <td>{{ $purchace['referenceCode'] }}</td>
                                            <td>{{ $purchace['sup_name'] }}</td>

                                            <?php
                                            switch ($purchace['status']):
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

                                            <td align="center">{!!$SaleStatus !!}</td>
                                            <td align="right">{{ $purchace['grand_total'] }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_3">
                                3
                            </div><!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_4">
                                4
                            </div><!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_5">
                                5
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- nav-tabs-custom -->
                {{--                        </div>--}}
                <!-- /.box-footer-->
                    {{--                    </div>--}}
                </div>

            </div>
        {{--    TOP 5 END --}}
        <!-- /.box -->

    </section>
    <style>
        button:hover, a:focus {
            color: #2a6496;
            text-decoration: none;
        }

        .square-service-block {
            position: relative;
            overflow: hidden;
            margin: 5px auto;
        }

        .square-service-block {
            /*background: #fff;*/
            /*border-radius: 2px;*/
            /*margin: 1rem;*/
        }

        .square-service-block button {
            border-radius: 15px;
            display: block;
            width: 95%;
            height: 130px;

        }

        .square-service-block button:hover {
            /*background-color: #80bdff;*/
            /*border-radius: 15px;*/
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            transition: all 0.3s cubic-bezier(.25, .8, .25, 1);
        }

        .ssb-icon {
            color: #1d2124;
            display: inline-block;
            font-size: 28px;
        }

        h2.ssb-title {
            color: #1d2124;
            font-size: 12px;
            font-weight: bolder;
            text-transform: uppercase;
            margin: 12px;
        }

        .square-service-block:hover .incon-box i {
            background: #fff;
            border: 3px solid #3C8DBC;
            color: #3C8DBC;
            /*transition: all;*/
            transition: all .4s ease-in;

        }

        .incon-box i {
            font-size: 35px;
            color: #fff;
            background: #3C8DBC;
            height: 55px;
            width: 55px;
            line-height: 50px;
            border: 3px solid transparent;
            /*transition: all;*/
            transition: all .4s ease-in;
        }

    </style>
@stop