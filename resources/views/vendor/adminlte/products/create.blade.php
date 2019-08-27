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
        <li class="active">Product Create</li>
    </ol>
@stop

@section('content')
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
                <div class="row">
                    <form role="form" action="{{url('products/create')}}" method="post" enctype="multipart/form-data">
                        <div class="col-md-6">

                            <div class="box-body">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="product_name">Product Name *</label>
                                    <input type="text" value="{{ old('product_name') }}" class="form-control"
                                           id="product_name" name="product_name"
                                           placeholder="Enter product name" autocomplete="off"/>
                                    @error('product_name')
                                    <p class="help-block">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="product_name">Product Code *</label>
                                    <input type="text" value="{{ old('product_code') }}" class="form-control"
                                           id="product_code" name="product_code"
                                           placeholder="Enter product code" autocomplete="off"/>
                                    @error('product_code')
                                    <p class="help-block">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="sku">SKU *</label>
                                    <input type="text" value="{{ old('sku') }}" class="form-control" id="sku" name="sku"
                                           placeholder="Enter sku"
                                           autocomplete="off"/>
                                    @error('sku')
                                    <p class="help-block">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="product_name">Secondary Name</label>
                                    <input type="text" value="{{ old('secondary_name') }}" class="form-control"
                                           id="secondary_name" name="secondary_name"
                                           placeholder="Enter secondary name" autocomplete="off"/>
                                    @error('secondary_name')
                                    <p class="help-block">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="product_name">Weight *</label>
                                    <input type="text" value="{{ old('weight') }}" class="form-control" id="weight"
                                           name="weight"
                                           placeholder="Enter Weight" autocomplete="off"/>
                                    @error('weight')
                                    <p class="help-block">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="product_name">Brand *</label>
                                    <select class="form-control" name="brand" id="brand">
                                        @if(old("brand") == 0)
                                            <option selected="selected" value="0">Select Brand</option>
                                        @endif
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand['id'] }}" {{ (old("brand") == $brand['id'] ? "selected":"") }}>{{ $brand->brand }}</option>
                                        @endforeach
                                    </select>
                                    @error('brand')
                                    <p class="help-block">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="product_name">Category *</label>
                                    <select class="form-control" name="category" id="category">
                                        @if(old("category") == 0)
                                            <option selected="selected" value="0">Select Category</option>
                                        @endif
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id}}" {{ (old("category") == $category->id? "selected":"") }}>{{ $category->category }}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                    <p class="help-block">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="product_name">Product Unit *</label>
                                    <select class="form-control" name="unit" id="unit">
                                        @if(old("unit") == 0)
                                            <option selected="selected" value="0">Select Unit</option>
                                        @endif
                                        <option value="1" {{ (old("unit") == 1? "selected":"") }}>Meter (m)</option>
                                        <option value="2" {{ (old("unit") == 2? "selected":"") }}>Piece (pc)</option>
                                        <option value="3" {{ (old("unit") == 3? "selected":"") }}>Kilogram (Kg)</option>
                                    </select>
                                    @error('unit')
                                    <p class="help-block">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="price">Product Price *</label>
                                    <input type="text" value="{{ old('price') }}" class="form-control" id="price"
                                           name="price"
                                           placeholder="Enter price"
                                           autocomplete="off"/>
                                    @error('price')
                                    <p class="help-block">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="price">Product Cost *</label>
                                    <input type="text" value="{{ old('cost') }}" class="form-control" id="cost"
                                           name="cost"
                                           placeholder="Enter cost"
                                           autocomplete="off"/>
                                    @error('cost')
                                    <p class="help-block">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="price">Product Tax</label>
                                    <select class="form-control" name="tax" id="tax">
                                        @if(old("tax") == 0)
                                            <option selected="selected" value="0">No Tax</option>
                                        @endif
                                        @foreach($taxes as $tax)
                                            <option value="{{ $tax->id}}" {{ (old("category") == $tax->id? "selected":"") }}>{{ $tax->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="price">Tax Method</label>
                                    <select class="form-control" name="tax_activation" id="tax_activation">
                                        <option value="1" {{ (old("tax_activation") == 1? "selected":"") }}>Exclusive
                                        </option>
                                        <option value="2" {{ (old("tax_activation") == 2? "selected":"") }}>Inclusive
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea type="text" class="form-control" id="description" name="description"
                                              placeholder="Enter description"
                                              autocomplete="off">{{ old('description') }}</textarea>

                                </div>
                                <div class="form-group">
                                    <label for="description">Alert Quantity</label>
                                    <div class="input-group">
                                            <span class="input-group-addon">
                                              <input type="checkbox"
                                                     {{ (old("reorder_activate") == 'on'? "checked":"") }} name="reorder_activate"
                                                     id="reorder_activate">
                                            </span>
                                        <input type="text" value="{{ old('reorder_level') }}" class="form-control"
                                               name="reorder_level"
                                               placeholder="Reorder level"
                                               id="reorder_level">
                                    </div>
                                    @error('reorder_level')
                                    <p class="help-block">{{ $message }}</p>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label for="product_image">Image</label>
                                    <br>
                                    <br>
                                    <?php
                                    $url = asset(url('/img/default.jpg'));
                                    ?>
                                    <img src="{{$url}}" class="rounded-circle z-depth-1-half avatar-pic"
                                         alt="placeholder default" style="width: 200px;height: 200px">

                                    <div class="btn btn-mdb-color btn-rounded float-center">
                                        <input name="product_image" id="product_image" type="file">
                                    </div>

                                </div>


                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                <a href="" class="btn btn-warning">Back</a>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Supplier/s *<?php print_r(old("supplier"))?></label>
                                    <select class="form-control select2" multiple="multiple" name="supplier[]"
                                            id="supplier"
                                            data-placeholder="Select a State"
                                            style="width: 100%;">
                                        @foreach($suppliers as $key =>  $supplier)
                                            <option value="{{ $supplier->id}}" {{ (isset(old("supplier")[$key]))?(old("supplier")[$key]== $supplier->id? "selected":""):'' }}>{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('supplier')
                                    <p class="help-block">{{ $message }}</p>
                                    @enderror
                                </div>
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
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()
        })
    </script>

@endsection
