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
    <ol class="breadcrumb">
        <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url('user/manage')}}">Manage Users</a></li>
        <li class="active">Edit User</li>
    </ol>
@stop

@section('content')
    <!-- Main content -->
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
                <h3 class="box-title">Edit User</h3>

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
                <form role="form" enctype="multipart/form-data" action="{{url('user/editSave')}}" method="post">
                    <div class="box-body">
                        {{csrf_field()}}
                        <div class="form-group"><input type="hidden" name="userid" id="userid"
                                                       value="{{$user[0]->id}}">
                            <label for="groups">Role</label>
                            <select class="form-control select2" id="role" name="role">
                                @if(old("role") == 0)
                                    <option selected="selected" value="0">Select Role</option>
                                @endif

                                @foreach($roles as $role)
                                    @if($user[0]->roles[0]['id']==$role['id'])
                                        <option value="{{ $role['id'] }}" selected>{{ $role['name'] }}</option>
                                    @else
                                        <option value="{{ $role['id'] }}" {{ (old("role") == $role['id'] ? "selected":"") }}>{{ $role['name'] }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('role')
                            <p class="help-block">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control"
                                   value="<?= (old('email') != '') ? old('email') : $user[0]->email;?>" id="email"
                                   name="email"
                                   placeholder="Email"
                                   autocomplete="off">
                            @error('email')
                            <p class="help-block">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="fname">Full name</label>
                            <input type="text" class="form-control"
                                   value="<?= (old('fname') != '') ? old('fname') : $user[0]->name;?>" id="fname"
                                   name="fname"
                                   placeholder="First name"
                                   autocomplete="off">
                            @error('fname')
                            <p class="help-block">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control"
                                   value="<?= (old('phone') != '') ? old('phone') : $user[0]->phone;?>" id="phone"
                                   name="phone"
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
                                    <input type="radio"
                                           @if(old('gender') ==  1 || $user[0]->gender==1) checked="checked"
                                           @endif name="gender"
                                           id="male" value="1">
                                    Male
                                </label>
                                <label>
                                    <input type="radio"
                                           @if(old('gender') ==  2 || $user[0]->gender==2) checked="checked"
                                           @endif name="gender"
                                           id="female" value="2">
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
                            <?php
                            $url = asset(Storage::url($user[0]->avatar));
                            ?>
                            <img src="{{ ($url) }}" class="rounded-circle z-depth-1-half avatar-pic"
                                 alt="placeholder avatar">

                            <div class="btn btn-mdb-color btn-rounded float-center">
                                <input name="avatar" type="file">
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="password">Current Password</label>
                            <input type="password" class="form-control" id="password"
                                   name="password" placeholder="Current Password"
                                   autocomplete="off">
                            @error('password')
                            <p class="help-block">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" class="form-control" id="new_password"
                                   name="new_password" placeholder="New Password"
                                   autocomplete="off">
                            @error('new_password')
                            <p class="help-block">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm password</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                   name="password_confirmation"
                                   placeholder="Confirm Password" autocomplete="off">
                            @error('password_confirmation')
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
