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
        <li><a href="{{url('products/manage')}}" class="active">Product Manage</a></li>
        <li class="active">Edit Product</li>
    </ol>
@stop

@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Products Update</h3>

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
                    <form role="form" action="{{url('products/edit')}}" method="post" enctype="multipart/form-data">
                        <div class="col-md-6">

                            <div class="box-body">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="product_name">Product Name<span class="mandatory"> *</span></label>
                                    <input type="hidden" id="id" name="id" value="{{$product->id}}">
                                    <input type="text"
                                           value="<?= (old('product_name') != '') ? old('product_name') : $product->name;?>"
                                           class="form-control"
                                           id="product_name" name="product_name"
                                           placeholder="Enter product name" autocomplete="off"/>
                                    @error('product_name')
                                    <p class="help-block">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="product_name">Product Code<span class="mandatory"> *</span></label>
                                    <input type="text"
                                           value="<?= (old('product_code') != '') ? old('product_code') : $product->item_code;?>"
                                           class="form-control"
                                           id="product_code" name="product_code"
                                           placeholder="Enter product code" autocomplete="off"/>
                                    @error('product_code')
                                    <p class="help-block">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="sku">SKU<span class="mandatory"> *</span></label>
                                    <input type="text" value="<?= (old('sku') != '') ? old('sku') : $product->sku;?>"
                                           class="form-control" id="sku" name="sku"
                                           placeholder="Enter sku"
                                           autocomplete="off"/>
                                    @error('sku')
                                    <p class="help-block">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="product_name">Secondary Name</label>
                                    <input type="text"
                                           value="<?= (old('secondary_name') != '') ? old('secondary_name') : $product->short_name;?>"
                                           class="form-control"
                                           id="secondary_name" name="secondary_name"
                                           placeholder="Enter secondary name" autocomplete="off"/>
                                    @error('secondary_name')
                                    <p class="help-block">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="product_name">Weight (Kg)<span class="mandatory"> *</span></label>
                                    <input type="text"
                                           value="<?= (old('weight') != '') ? old('weight') : $product->weight;?>"
                                           class="form-control" id="weight"
                                           name="weight"
                                           placeholder="Enter Weight" autocomplete="off"/>
                                    @error('weight')
                                    <p class="help-block">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="product_name">Brand<span class="mandatory"> *</span></label>
                                    <select class="form-control" name="brand" id="brand">
                                        @if(old("brand") == 0)
                                            <option selected="selected" value="0">Select Brand</option>
                                        @endif
                                        @foreach($brands as $brand)
                                            @if($product->brands->id==$brand['id'])
                                                <option value="{{ $brand['id'] }}"
                                                        selected>{{ $brand->brand }}</option>
                                            @else
                                                <option value="{{ $brand['id'] }}" {{ (old("brand") == $brand['id'] ? "selected":"") }}>{{ $brand->brand }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('brand')
                                    <p class="help-block">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="product_name">Category<span class="mandatory"> *</span></label>
                                    <select class="form-control" name="category" id="category">
                                        @if(old("category") == 0)
                                            <option selected="selected" value="0">Select Category</option>
                                        @endif
                                        @foreach($categories as $category)
                                            @if($product->categories->id==$category['id'])
                                                <option value="{{ $category->id}}"
                                                        selected>{{ $category->category }}</option>
                                            @else
                                                <option value="{{ $category->id}}" {{ (old("category") == $category->id? "selected":"") }}>{{ $category->category }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('category')
                                    <p class="help-block">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="product_name">Product Unit<span class="mandatory"> *</span></label>
                                    <select class="form-control" name="unit" id="unit">
                                        @if(old("unit") == 0)
                                            <option selected="selected" value="0">Select Unit</option>
                                        @endif
                                        <option value="1" {{ (old("unit")||$product->unit == 1? "selected":"") }}>
                                            Meter (m)
                                        </option>
                                        <option value="2" {{ (old("unit")||$product->unit == 2? "selected":"") }}>
                                            Piece (pc)
                                        </option>
                                        <option value="3" {{ (old("unit")||$product->unit == 3? "selected":"") }}>
                                            Kilogram (Kg)
                                        </option>
                                    </select>
                                    @error('unit')
                                    <p class="help-block">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="price">Product Price<span class="mandatory"> *</span></label>
                                    <input type="text"
                                           value="<?= (old('price') != '') ? old('price') : $product->selling_price;?>"
                                           class="form-control" id="price"
                                           name="price"
                                           placeholder="Enter price"
                                           autocomplete="off"/>
                                    @error('price')
                                    <p class="help-block">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="price">Product Cost (Rs)<span class="mandatory"> *</span></label>
                                    <input type="text"
                                           value="<?= (old('cost') != '') ? old('cost') : $product->cost_price;?>"
                                           class="form-control" id="cost"
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
                                        @if(old("unit") == 0)
                                            <option value="0">No tax</option>
                                        @endif
                                        @foreach($taxes as $tax)
                                            <option value="{{ $tax->id}}" {{ (old("category") == $tax->id||$tax->id ==$product->tax? "selected":"") }}>{{ $tax->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="price">Tax Method</label>
                                    <select class="form-control" name="tax_activation" id="tax_activation">
                                        <option value="1" {{ (old("tax_activation")||$product->tax_method == 1? "selected":"") }}>
                                            Exclusive
                                        </option>
                                        <option value="2" {{ (old("tax_activation")||$product->tax_method == 2? "selected":"") }}>
                                            Inclusive
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea type="text" class="form-control" id="description" name="description"
                                              placeholder="Enter description"
                                              autocomplete="off"><?= (old('description') != '') ? old('description') : $product->description;?></textarea>

                                </div>
                                <div class="form-group">
                                    <label for="description">Alert Quantity</label>
                                    <div class="input-group">
                                            <span class="input-group-addon">
                                              <input type="checkbox"
                                                     {{ (old("reorder_activate") == 'on'|| $product->reorder_activation==0? "checked":"") }} name="reorder_activate"
                                                     id="reorder_activate">
                                            </span>
                                        <input type="text"
                                               value="<?= (old('reorder_level') != '') ? old('reorder_level') : $product->reorder_level;?>"
                                               class="form-control"
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

                                    <img src="{{asset(\Storage::url($product->img_url))}}"
                                         class="rounded-circle z-depth-1-half avatar-pic"
                                         alt="placeholder default" style="width: 200px;height: 200px">

                                    <div class="btn btn-mdb-color btn-rounded float-center">
                                        <input name="product_image" id="product_image" type="file">
                                    </div>

                                </div>


                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                <a onclick="window.history.back()" class="btn btn-warning">Back</a>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Supplier/s<span class="mandatory"> *</span></label>
                                    <select class="form-control select2" multiple="multiple" name="supplier[]"
                                            id="supplier"
                                            data-placeholder="Select a State"
                                            style="width: 100%;">
                                        @foreach($suppliers as $key =>  $supplier)
                                            <?php $count = 1;?>
                                            @foreach($product->supplier as $selectedsup)
                                                @if($selectedsup->id==$supplier->id || isset(old("supplier")[$key]))
                                                    <?php if($count == 1){ $count++;  ?>
                                                    <option value="{{ $supplier->id}}"
                                                            selected>{{$selectedsup->name }}</option>
                                                    <?php }?>
                                                @endif
                                            @endforeach
                                            @if($count==1)
                                                <option value="{{ $supplier->id}}" {{ (isset(old("supplier")[$key]))?(old("supplier")[$key]== $supplier->id? "selected":""):'' }}>{{ $supplier->name }}</option>
                                            @endif
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


@endsection
