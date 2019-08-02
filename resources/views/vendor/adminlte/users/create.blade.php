<?php
/**
 * Created by PhpStorm.
 * User: harshan
 * Date: 3/26/19
 * Time: 2:00 AM
 */
?>
@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <!-- Main content -->
    <style>
        .help-block {
            color: red;
        }
        .avatar-pic {
            width: 100px;
            height: 100px;
        }
    </style>
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Add User</h3>

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
                @if(session()->has('message'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong> {{ session()->get('message') }}
                    </div>
                @endif

                <form role="form" enctype="multipart/form-data" action="{{url('user/create')}}" method="post">
                    <div class="box-body">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="groups">Role</label>
                            <select class="form-control select2" id="role" name="role">
                                @if(old("role") == 0)
                                    <option selected="selected" value="0">Select Role</option>
                                @endif
                                @foreach($roles as $role)
                                    <option value="{{ $role['id'] }}" {{ (old("role") == $role['id'] ? "selected":"") }}>{{ $role['name'] }}</option>
                                @endforeach
                            </select>
                            @error('role')
                            <p class="help-block">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" value="{{ old('email') }}" id="email" name="email"
                                   placeholder="Email"
                                   autocomplete="off">
                            @error('email')
                            <p class="help-block">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="fname">Full name</label>
                            <input type="text" class="form-control" value="{{ old('fname') }}" id="fname" name="fname"
                                   placeholder="First name"
                                   autocomplete="off">
                            @error('fname')
                            <p class="help-block">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" value="{{ old('phone') }}" id="phone" name="phone"
                                   placeholder="Phone"
                                   autocomplete="off">
                            @error('phone')
                            <p class="help-block">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <div class="radio">
                                <label>
                                    <input type="radio"  @if(old('gender') ==  1) checked="checked" @endif name="gender" id="male" value="1">
                                    Male
                                </label>
                                <label>
                                    <input type="radio" @if(old('gender') ==  2) checked="checked" @endif name="gender" id="female" value="2">
                                    Female
                                </label>
                            </div>
                            @error('gender')
                            <p class="help-block">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="avatar">Avatar</label>
                            <br>
                            <br>
                            <img  src="{{ asset('img/avatar.png') }}"  class="rounded-circle z-depth-1-half avatar-pic" alt="placeholder avatar">

                            <div class="btn btn-mdb-color btn-rounded float-center">
                                <input name="avatar" type="file">
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" value="{{ old('username') }}" id="password"
                                   name="password" placeholder="Password"
                                   autocomplete="off">
                            @error('password')
                            <p class="help-block">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="cpassword">Confirm password</label>
                            <input type="password" class="form-control" value="{{ old('cpassword') }}" id="cpassword"
                                   name="cpassword"
                                   placeholder="Confirm Password" autocomplete="off">
                            @error('cpassword')
                            <p class="help-block">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <a href="" class="btn btn-warning">Back</a>
                    </div>
                </form>

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
