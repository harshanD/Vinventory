@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Dashboard</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="card-body">
                    <div class="row">
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
                        {{--col-lg-3 col-md-6 col-xm-2--}}
                        <div class="col-sm-4 col-lg-3 col-md-6 col-xm-2">
                            <div class="square-service-block">
                                <a href="{{url('/location')}}">
                                    <button href="#" class="btn btn-default">
                                        <div class="ssb-icon">
                                            <div class="incon-box">
                                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <h2 class="ssb-title">Location</h2>
                                    </button>
                                </a>
                            </div>
                        </div>
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
                        <div class="col-sm-4 col-lg-3 col-md-6 col-xm-2">
                            <div class="square-service-block">
                                <a href="#">
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
                        <div class="col-sm-4 col-lg-3 col-md-6 col-xm-2">
                            <div class="square-service-block">
                                <a href="#">
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
                        <div class="col-sm-4 col-lg-3 col-md-6 col-xm-2">
                            <div class="square-service-block">
                                <a href="#">
                                    <button href="#" class="btn btn-default">
                                        <div class="ssb-icon">
                                            <div class="incon-box">
                                                <i class="fa fa-arrow-circle-down" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <h2 class="ssb-title">GRN</h2>
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-4 col-lg-3 col-md-6 col-xm-2">
                            <div class="square-service-block">
                                <a href="#">
                                    <button href="#" class="btn btn-default">
                                        <div class="ssb-icon">
                                            <div class="incon-box">
                                                <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <h2 class="ssb-title">GTN</h2>
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-4 col-lg-3 col-md-6 col-xm-2">
                            <div class="square-service-block">
                                <a href="#">
                                    <button href="#" class="btn btn-default">
                                        <div class="ssb-icon">
                                            <div class="incon-box">
                                                <i class="fa fa-file-alt" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <h2 class="ssb-title">MRN</h2>
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-4 col-lg-3 col-md-6 col-xm-2">
                            <div class="square-service-block">
                                <a href="#">
                                    <button href="#" class="btn btn-default">
                                        <div class="ssb-icon">
                                            <div class="incon-box">
                                                <i class="fa fa-banknotes" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <h2 class="ssb-title">Invoice</h2>
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-4 col-lg-3 col-md-6 col-xm-2">
                            <div class="square-service-block">
                                <a href="#">
                                    <button href="#" class="btn btn-default">
                                        <div class="ssb-icon">
                                            <div class="incon-box">
                                                <i class="glyphicon glyphicon-stats" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <h2 class="ssb-title">Reports</h2>
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-4 col-lg-3 col-md-6 col-xm-2">
                            <div class="square-service-block">
                                <a href="#">
                                    <button href="#" class="btn btn-default">
                                        <div class="ssb-icon">
                                            <div class="incon-box">
                                                <i class="fa fa-align-center" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <h2 class="ssb-title">Administration</h2>
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-4 col-lg-3 col-md-6 col-xm-2">
                            <div class="square-service-block">
                                <a href="#">
                                    <button href="#" class="btn btn-default">
                                        <div class="ssb-icon">
                                            <div class="incon-box">
                                                <i class="fa fa-cogs" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <h2 class="ssb-title">Settings</h2>
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
            </div>
            <!-- /.box-footer-->
        </div>
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