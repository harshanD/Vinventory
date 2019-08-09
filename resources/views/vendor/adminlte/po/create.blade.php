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
    <h1>Dashboard</h1>
@stop

@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Purchase order Create</h3>

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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Date *</label>

                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" placeholder="Select Date" name="datepicker"
                                       class="form-control pull-right" id="datepicker">
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Status *</label>

                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <select class="form-control select2" name="status" id="status">
                                    <option selected="selected" value="0">Select Status</option>
                                    <option value="1">Received</option>
                                    <option value="2">Pending</option>
                                    <option value="3">Ordered</option>

                                </select>
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Location *</label>

                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <select class="form-control select2" name="location" id="location">
                                    <option selected="selected" value="0">Select Location</option>
                                    @foreach($locations as $location)
                                        <option value="{{$location->id}}">{{$location->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Reference No</label>

                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control"  name="referenceNo" id="referenceNo">
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Please select these before adding any product</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-horizontal">

                        <label>Supplier *</label>

                        <div class="input-group date col-xs-4">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <select class="form-control col-xs-4 select2" name="supplier" id="supplier">
                                <option selected="selected" value="0">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                @endforeach

                            </select>
                        </div>

                        <!-- /.box-body -->

                    </form>
                </div>
                <!-- /.box -->
                <div class="input-group input-group-lg">
                  <span class="input-group-btn">
                            <a class="btn btn-app">
                                <i class="fa fa-barcode"></i>
                            </a>
                   </span>
                    <input type="text" id="product" class="form-control input-lg"
                           placeholder="Please add products to order list">
                    <span class="input-group-btn">
                                  <a class="btn btn-app">
                                <i class="fa glyphicon glyphicon-plus"></i>
                            </a>
                    </span>
                </div>
            </div>

            <div class="box-body">
                <table id="poTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Product (Code - Name)</th>
                        <th>Net Unit Cost</th>
                        <th>Quantity</th>
                        <th>Discount</th>
                        <th>Product Tax</th>
                        <th>Subtotal</th>
                        <th style="text-align:center"><i class="fa fa-trash"></i></th>
                    </tr>
                    </thead>
                    <tbody id="poBody">


                    </tbody>
                </table>
            </div>

            <div class="box-body">
                <div class="checkbox">
                    <label data-toggle="collapse" data-target="#collapseOptions" class="collapsed"
                           aria-expanded="false">
                        <input type="checkbox" checked class="flat-red"/>More Options
                    </label>
                </div>

                <!-- /.box -->
            </div>
            <div class="box-body">
                <div id="collapseOptions" class="collapse">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Order Tax</label>

                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <select class="form-control select2" name="wholeTax" id="wholeTax">
                                        <option selected="selected" value="0">Select Status</option>
                                        <option value="1">Received</option>
                                        <option value="2">Pending</option>
                                        <option value="3">Ordered</option>

                                    </select>
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Discount (5/7%)</label>

                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <select class="form-control select2" name="wholeDiscount" id="wholeDiscount">
                                        <option selected="selected" value="0">Select Status</option>
                                        <option value="1">Received</option>
                                        <option value="2">Pending</option>
                                        <option value="3">Ordered</option>

                                    </select>
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Note</label>

                                <div class="input-group">
                                    <div class="input-group-addon">
                                        {{--                                        <i class="fa fa-calendar"></i>--}}
                                    </div>
                                    <textarea type="text" class="form-control" id="note" name="note"
                                              placeholder="Note"
                                              autocomplete="off"></textarea>
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="" class="btn btn-warning">Back</a>
                </div>
                <div id="footer" class="box-body"></div>
            </div>

        </div>
        <!-- /.box -->

    </section>

    <script>


        var autoCompleteId = 'product';
        var options = {

            url: "/products/fetchProductsList",

            getValue: "name",

            list: {
                maxNumberOfElements: 8,
                match: {
                    enabled: true
                },
                sort: {
                    enabled: true
                },
                onChooseEvent: function () {
                    var index = $("#" + autoCompleteId).getSelectedItemData();
                    $('#product').val('');
                    changeProduct(index)
                }
            },

            // theme: "square"
            theme: "plate-dark"
        };

        var itemCount = 0;

        function changeProduct(index) {
            // localStorage.clear();
            if (document.getElementById("row_" + index.id) === null) {
                localStorage.setItem('item', JSON.stringify(index.id));
                itemCount++;

                var row = '<tr id="row_' + index.id + '" style="text-align: right">' +
                    "<td style=\"text-align: left\">" + index.name + "( " + index.item_code + " )" + "</td>" +
                    "<td id='costPrice_" + index.id + "'>" + index.cost_price + "</td>" +
                    "<td style=\"text-align: center\"><input type='text'   style=\"text-align: center\" onkeyup='qtyChanging(" + index.id + ")' id='quantity_" + index.id + "' value='" + 0 + "'></td>" +
                    "<td>" + index.discount + "</td>" +
                    "<td>" + index.tax + "</td>" +
                    "<td class='subtot' id='subtot_" + index.id + "'>" + 0 + "</td>" +
                    '<td style="text-align: center"><i class="glyphicon glyphicon-remove" onclick="removeThis(' + index.id + ')" style="cursor: pointer"></i></td>';

                row += '</tr>';
                $('.lastRow').remove()
                $('#poBody').append(row);
            }
        }

        function qtyChanging(id) {
            var subTot = parseFloat($('#costPrice_' + id).text()) * parseFloat($('#quantity_' + id).val())

            $('#subtot_' + id).text(((!isNaN(subTot)) ? subTot : 0).toFixed(2));

            /*      var lastRow= '<tr >' +
                      "<td colspan='3'></td>" +
                      "<td id='sumQuantity'></td>" +
                      "<td id='sumDiscount'></td>" +
                      "<td id='sumTax'></td>" +
                      "<td id='sumTax'></td></tr>"; */
            lastRowDesign();
        }

        function lastRowDesign() {
            var sum = 0;
            $('.subtot').each(function () {
                sum += parseFloat($(this).text());  // Or this.innerHTML, this.innerText
            });

            var lastRow = '<tr class="lastRow" style="font-weight: bold;text-align: right">' +
                "<td colspan='3' style='text-align: left'>Total</td>" +
                "<td id='sumQuantity'>" + 0 + "</td>" +
                "<td id='sumDiscount'>" + 0 + "</td>" +
                "<td id='sumTax' style='align:right'>" + sum.toFixed(2) + "</td><td style='text-align: center'><i class=\"fa fa-trash\"></i></td></tr>";

            $('.lastRow').remove();
            $('#poBody').append(lastRow);

            var footerRow = "<table class=\"table table-bordered\" ><tr style=\"font-weight: bold;text-align: right;color: #0d6aad\">" +
                "<td style='text-align: left;background-color: #dfe4da;width: 13%'>Items</td>" +
                "<td style='text-align: right;background-color: #c2c7bd;width: 7%'>" + ($('#poTable tr').length - 2) + "</td>" +
                "<td style='text-align: left;background-color: #dfe4da;width: 13%'>Total</td>" +
                "<td style='text-align: right;background-color: #c2c7bd;width: 7%'>" + sum + "</td>" +
                "<td style='text-align: left;background-color: #dfe4da;width: 13%'>Order Discount</td>" +
                "<td style='text-align: right;background-color: #c2c7bd;width: 7%'>" + 0 + "</td>" +
                "<td style='text-align: left;background-color: #dfe4da;width: 13%'>Order Tax</td>" +
                "<td style='text-align: right;background-color: #c2c7bd;width: 7%'>" + 0 + "</td>" +
                "<td style='text-align: left;background-color: #dfe4da;width: 13%'>Grand Total</td>" +
                "<td style='text-align: right;background-color: #c2c7bd;width: 7%'>" + 0 + "</td><tr></table>";


            $('#footer').html(footerRow);
        }

        function removeThis(removeRow) {
            $('#row_' + removeRow).remove()
            lastRowDesign()
        }


    </script>
@endsection
