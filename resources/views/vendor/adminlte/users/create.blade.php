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
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Add User</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">


                <form role="form" action="" method="post">
                    <div class="box-body">

                        <div class="form-group">
                            <label for="groups">Role</label>
                            <select class="form-control select2"  id="groups" name="groups">
                                <option value="">Select Role</option>
                                <option selected="selected">Select Groups 1</option>

                            </select>
                        </div>


                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="text" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="cpassword">Confirm password</label>
                            <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm Password" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="fname">First name</label>
                            <input type="text" class="form-control" id="fname" name="fname" placeholder="First name" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="lname">Last name</label>
                            <input type="text" class="form-control" id="lname" name="lname" placeholder="Last name" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="gender" id="male" value="1">
                                    Male
                                </label>
                                <label>
                                    <input type="radio" name="gender" id="female" value="2">
                                    Female
                                </label>
                            </div>
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
