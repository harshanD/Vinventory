<?php
/**
 * Created by PhpStorm.
 * User: harshan
 * Date: 3/27/19
 * Time: 3:50 AM
 */
?>
@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <ol class="breadcrumb">
        <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url('/customer/manage')}}">Manage Customers</a></li>
        <li class="active">Customer Edit</li>
    </ol>
@stop

@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Customer Edit</h3>

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
                <div class="row">
                    <form role="form" action="{{url('customer/edit/'.$customer->id)}}" method="post"
                          enctype="multipart/form-data">
                        <div class="col-md-6">
                            {{csrf_field()}}
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

                            <div class="box-body">

                                <div class="form-group">
                                    <label for="product_name">Company *</label>
                                    <input type="text"
                                           value="{{ (old('company')===null)?$customer->company:old('company')  }}"
                                           class="form-control"
                                           id="company" name="company"
                                           placeholder="Enter product name" autocomplete="off"/>
                                    @error('company')
                                    <p class="help-block">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="product_name">Name *</label>
                                    <input type="text" value="{{ (old('name')===null)?$customer->name:old('name') }}"
                                           class="form-control"
                                           id="name" name="name"
                                           placeholder="Enter product code" autocomplete="off"/>
                                    @error('name')
                                    <p class="help-block">{{ $message }}</p>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label for="product_name">Email Address *</label>
                                    <input type="text" value="{{ (old('email')===null)?$customer->email:old('email') }}"
                                           class="form-control"
                                           id="email" name="email"
                                           placeholder="Enter secondary name" autocomplete="off"/>
                                    @error('email')
                                    <p class="help-block">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="product_name">Phone *</label>
                                    <input type="text" value="{{ (old('phone')===null)?$customer->phone:old('phone') }}"
                                           class="form-control" id="phone"
                                           name="phone"
                                           placeholder="Enter Phone Number" autocomplete="off"/>
                                    @error('phone')
                                    <p class="help-block">{{ $message }}</p>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label for="price">Address *</label>
                                    <input type="text"
                                           value="{{  (old('address')===null)?$customer->address:old('address') }}"
                                           class="form-control" id="address"
                                           name="address"
                                           placeholder="Enter cost"
                                           autocomplete="off"/>
                                    @error('address')
                                    <p class="help-block">{{ $message }}</p>
                                    @enderror
                                </div>


                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                <a onclick="window.history.back()" class="btn btn-warning">Back</a>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
            <!-- /.box-body -->
        {{--<div class="box-footer">--}}
        {{--Footer--}}
        {{--</div>--}}
        <!-- /.box-footer-->
        </div>
        <!-- /.box -->

    </section>
@endsection