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
                <!-- /.box-body -->
                <div class="box-footer">
                </div>
                <!-- /.box-footer-->
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