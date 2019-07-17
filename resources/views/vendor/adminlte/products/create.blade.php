<?php
/**
 * Created by PhpStorm.
 * User: harshan
 * Date: 3/27/19
 * Time: 3:50 AM
 */
?>
@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Products Create
@endsection


@section('main-content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Products Create</h3>

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

                <form role="form" action="" method="post" enctype="multipart/form-data">
                    <div class="box-body">

                        <div class="form-group">

                            <label for="product_image">Image</label>
                            <div class="kv-avatar">
                                <div class="file-loading">
                                    <input id="product_image" name="product_image" type="file">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="product_name">Product name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name"
                                   placeholder="Enter product name" autocomplete="off"/>
                        </div>

                        <div class="form-group">
                            <label for="sku">SKU</label>
                            <input type="text" class="form-control" id="sku" name="sku" placeholder="Enter sku"
                                   autocomplete="off"/>
                        </div>

                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="text" class="form-control" id="price" name="price" placeholder="Enter price"
                                   autocomplete="off"/>
                        </div>

                        <div class="form-group">
                            <label for="qty">Qty</label>
                            <input type="text" class="form-control" id="qty" name="qty" placeholder="Enter Qty"
                                   autocomplete="off"/>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea type="text" class="form-control" id="description" name="description" placeholder="Enter description" autocomplete="off">
                  </textarea>
                        </div>


                        <div class="form-group">
                            <label for="brands">Brands</label>
                            <select class="form-control " id="brands" name="brands[]" multiple="multiple">
                                <option value="">1</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-control" id="category" name="category[]" multiple="multiple">
                                <option value="">1</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="store">Store</label>
                            <select class="form-control" id="store" name="store">
                                <option value="">Location 1</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="store">Availability</label>
                            <select class="form-control" id="availability" name="availability">
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
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
