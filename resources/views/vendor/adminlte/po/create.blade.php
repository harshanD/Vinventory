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
            <form role="form" enctype="multipart/form-data" action="{{url('po/create')}}" method="post">
                <div class="box-body">
                    {{csrf_field()}}
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
                                            <option value="0">Select Status</option>
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
                                            <option value="0">Select Location</option>
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
                                        <input type="text" class="form-control" name="referenceNo" id="referenceNo">
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
                                        <option value="0">Select Supplier</option>
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
                            <a class="btn btn-app" href="{{url('products')}}">
                                <i class="fa fa-barcode"></i>
                            </a>
                   </span>
                            <input type="text" id="product" class="form-control input-lg"
                                   placeholder="Please add products to order list">
                            <span class="input-group-btn">
                                  <a class="btn btn-app" href="{{url('products/create')}}">
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
                                            <select class="form-control select2" name="wholeTax" id="wholeTax"
                                                    onchange="lastRowDesign()">
                                                <option value="0">Select tax</option>
                                                @foreach($tax as $ta)
                                                    <option value="{{$ta->value}}">{{$ta->name ."-".$ta->code}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Discount (5/5%)</label>

                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control" name="wholeDiscount"
                                                   id="wholeDiscount" onkeyup="lastRowDesign()">
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
                            <a onclick="itemDetails(13)" class="btn btn-warning">Back</a>
                            <td style="text-align: center"><input type='text' style="text-align: center"
                                                                  id='quantity_13' value="0">
                        </div>
                        <div id="footer" class="box-body"></div>
                    </div>
                </div>
            </form>
        </div>

        <!-- /.box -->

        <div class="modal modal-danger fade" id="modal-danger">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Error</h4>
                    </div>
                    <div class="modal-body">
                        <p>Please select above first&hellip;</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal modal-danger" id="itemDetails">
            <div class="modal-dialog">
                <form class="form-horizontal">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title" id="itemName"></h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form class="form-horizontal">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label">Product Tax</label>
                                    <input type="hidden" id="modalItem">
                                    <div class="col-sm-6">
                                        <select class="form-control select2" name="pTax" id="pTax" style="width: 100%;"
                                                onchange="itemQtyCostUnitChange()">
                                            <option value="0">No tax</option>
                                            @foreach($tax as $ta)
                                                <option value="{{$ta->value}}">{{$ta->name ."-".$ta->code}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label">Quantity</label>

                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="pQty" name="pQty"
                                               onkeyup="itemQtyCostUnitChange()"
                                               placeholder="Quantity">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label">Product Unit</label>

                                    <div class="col-sm-6">
                                        <select class="form-control select2" name="pUnit" id="pUnit"
                                                style="width: 100%;" onchange="itemQtyCostUnitChange()">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label">Product Discount</label>

                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="pDisco" name="pDisco"
                                               onkeyup="itemQtyCostUnitChange()"
                                               placeholder="Discount">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label">Unit Cost</label>

                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="pCost" name="pCost"
                                               onkeyup="itemQtyCostUnitChange()"
                                               placeholder="Cost">
                                    </div>
                                </div>

                            </div>
                            <div class="box-body">
                                <table class="table table-bordered table-striped">
                                    <thead>

                                    <th style="width: 25%">Net Unit Cost</th>
                                    <th style="width: 25%" id="nucost"></th>
                                    <th style="width: 25%">Product Tax</th>
                                    <th style="width: 25%" id="ptx"></th>

                                    </thead>
                                </table>
                                <br>
                                <div class="panel panel-default">
                                    <div class="panel-heading">Calculate Unit Cost</div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label for="pcost" class="col-sm-4 control-label">Subtotal</label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="psubtotal">
                                                    <div class="input-group-addon" style="padding: 2px 8px;">
                                                        <a href="#" id="calculate_unit_price" onclick="reverseCal()"
                                                           class="tip" title=""
                                                           data-original-title="Calculate Unit Cost" tabindex="-1">
                                                            <i class="fa fa-calculator"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
                                <button type="button" onclick="modalDataSetToTable()" class="btn btn-info pull-right">
                                    Submit
                                </button>
                            </div>
                            <!-- /.box-footer -->
                        </form>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
        </div>

    </section>

    <script>


        var autoCompleteId = 'product';
        var acurl = '';

        $(document).ready(function () {

            $("#product").keyup(function () {
                $('#modal-danger').modal({
                    show: 'true'
                });
                $("#product").val('')
            });

            $("#supplier").change(function () {
                acurl = $('#supplier').val();


                var options = {


                    url: "/products/fetchProductsList/" + acurl,

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
                        },
                    },

                    // theme: "square"
                    theme: "plate-dark"
                };


                if (typeof autoCompleteId !== 'undefined') {
                    $("#" + autoCompleteId).easyAutocomplete(options);
                }

            });

        });
        //
        // function checkValuesExistsInProducts() {
        //     var containerList = $('#product').next('.easy-autocomplete-container').find('ul');
        //     if ($(containerList).children('li').length <= 0) {
        //         $(containerList).html('<li>No results found</li>').show();
        //     }
        // }

        var itemCount = 0;

        function changeProduct(index) {
            // localStorage.clear();
            if (document.getElementById("row_" + index.id) === null) {
                localStorage.setItem('item', JSON.stringify(index.id));
                itemCount++;

                var row = '<tr id="row_' + index.id + '" style="text-align: right">' +
                    "<td style=\"text-align: left\">" + index.name + "( " + index.item_code + " )" + "</td>" +
                    "<td id='costPrice_" + index.id + "'>" + index.cost_price + "</td>" +
                    "<td style=\"text-align: center\"><input type='text'   style=\"text-align: center\" class='qy' onkeyup='qtyChanging(" + index.id + ")' id='quantity_" + index.id + "' value='" + 0 + "'></td>" +
                    "<td id='discount_" + index.id + "'>" + index.discount + "</td>" +
                    "<td hidden id='hidden_data_" + index.id + "'><input type='hidden' id='unit_" + index.id + "'><input type='hidden' id='p_tax_" + index.id + "'></td>" +
                    "<td class='tax' id='tax_" + index.id + "'>" + index.tax + "</td>" +
                    "<td class='subtot' id='subtot_" + index.id + "'>" + 0 + "</td>" +
                    '<td style="text-align: center"><i class="glyphicon glyphicon-remove" onclick="removeThis(' + index.id + ')" style="cursor: pointer"></i></td>';

                row += '</tr>';
                $('.lastRow').remove()
                $('#poBody').append(row);
            }
        }

        function qtyChanging(id) {
            var subTot = ((toNumber($('#costPrice_' + id).text()) * toNumber($('#quantity_' + id).val())) + toNumber(($('#tax_' + id).text())))
// alert($('#costPrice_' + id).text()+" == "+ $('#quantity_' + id).val()+" ==== "+$('#unit_' + id).val())
            $('#subtot_' + id).text(((!isNaN(subTot)) ? subTot : 0).format(2));

            lastRowDesign();
        }

        function lastRowDesign() {
            var sum = 0;
            $('.subtot').each(function () {
                sum += toNumber($(this).text());  // Or this.innerHTML, this.innerText
            });
            var qtySum = 0;
            $('.qy').each(function () {
                qtySum += toNumber($(this).text());  // Or this.innerHTML, this.innerText
            });

            var lastRow = '<tr class="lastRow" style="font-weight: bold;text-align: right">' +
                "<td colspan='3' style='text-align: left'>Total</td>" +
                "<td id='sumQuantity'>" + 0 + "</td>" +
                "<td id='sumDiscount'>" + 0 + "</td>" +
                "<td id='sumTax' style='align:right'>" + sum.format(2) + "</td><td style='text-align: center'><i class=\"fa fa-trash\"></i></td></tr>";

            $('.lastRow').remove();
            $('#poBody').append(lastRow);

            var wdisco = (($('#wholeDiscount').val()).indexOf('%') > -1) ? (sum * $('#wholeDiscount').val().replace('%', '') / 100) : ($('#wholeDiscount').val());
            var wtax = ((toNumber(sum - wdisco) * toNumber($('#wholeTax').val())) / 100);
            var gtot = (sum - wdisco) + wtax;
            // var gtot = taxdeductSum - wdisco;

            var footerRow = "<table class=\"table table-bordered\" ><tr style=\"font-weight: bold;text-align: right;color: #0d6aad\">" +
                "<td style='text-align: left;background-color: #dfe4da;width: 13%'>Items</td>" +
                "<td style='text-align: right;background-color: #c2c7bd;width: 7%'>" + ($('#poTable tr').length - 2)+ " ("+ qtySum +") "+ "</td>" +
                "<td style='text-align: left;background-color: #dfe4da;width: 13%'>Total</td>" +
                "<td style='text-align: right;background-color: #c2c7bd;width: 7%'>" + sum.format(2) + "</td>" +
                "<td style='text-align: left;background-color: #dfe4da;width: 13%'>Order Discount</td>" +
                "<td style='text-align: right;background-color: #c2c7bd;width: 7%'>" + wdisco.format(2) + "</td>" +
                "<td style='text-align: left;background-color: #dfe4da;width: 13%'>Order Tax</td>" +
                "<td style='text-align: right;background-color: #c2c7bd;width: 7%'>" + wtax.format(2) + "</td>" +
                "<td style='text-align: left;background-color: #dfe4da;width: 13%'>Grand Total</td>" +
                "<td style='text-align: right;background-color: #c2c7bd;width: 7%'>" + gtot.format(2) + "</td><tr></table>";


            $('#footer').html(footerRow);
        }

        function removeThis(removeRow) {
            $('#row_' + removeRow).remove()
            lastRowDesign()
        }

        function itemDetails(id) {
            $.ajax('/products/fetchProductDataById', {
                type: 'post',  // http method
                data: {
                    id: id,
                    "_token": "{{ csrf_token() }}",
                },  // data to submit
                beforeSend: function () {
                    $('#itemDetails').modal({
                        show: 'true'
                    });
                    $('#modalItem').val(id)
                },
                success: function (data, status, xhr) {
                    var item = JSON.parse(data);
                    $('#pCost').val((toNumber(toNumber($('#costPrice_' + id).text()) + (toNumber($('#tax_' + id).text()) / toNumber($('#quantity_' + id).val())) + (toNumber($('#discount_' + id).text()) / toNumber($('#quantity_' + id).val())))).format(2));
                    $('#itemName').text(item.name + " ( " + item.item_code + ") ");
                    $('#pQty').val($('#quantity_' + id).val());
                    $('#pDisco').val();
                    $('#pUnit').html("");
                    if (item.unit == '2') { /*piece*/
                        var unitSelecter = "<option value='1'>Piece</option>" +
                            "<option value='12'>Dozen Box</option>";
                    } else if (item.unit == '1') { /*kilograms*/
                        var unitSelecter = "<option value='1'>Kilograms</option>";
                    } else { /*meter*/
                        var unitSelecter = "<option value='1'>meters</option>";
                    }

                    $('#pUnit').append(unitSelecter);
                    itemQtyCostUnitChange()
                    // alert(item.item_code)
                    console.log(data)
                },
                error: function (jqXhr, textStatus, errorMessage) {
                    $('p').append('Error' + errorMessage);
                }
            });
        }

        function itemQtyCostUnitChange() {


            var itemCost = ((toNumber($('#pCost').val())) - toNumber(($('#pDisco').val() == '') ? 0 : $('#pDisco').val()));
            // alert(itemCost)
            var tax = toNumber(toNumber(itemCost * toNumber($('#pTax').val())) / (100 + toNumber($('#pTax').val())));
            var taxDeductedCost = (toNumber((itemCost - tax)));
            // alert(tax)
            $('#ptx').text(tax.format(2));
            // alert(taxDeductedCost)
            $('#nucost').text(taxDeductedCost.format(2));
        }

        function reverseCal() {
            var subTotal = ($('#psubtotal').val() == '') ? 1 : $('#psubtotal').val();
            // var qty = toNumber($('#pQty').val()) * (toNumber($('#pUnit').val()));
            var qty = toNumber($('#pQty').val());
            $('#pCost').val((subTotal / qty).format(2))
            itemQtyCostUnitChange()
        }

        function modalDataSetToTable() {
            var itemId = $('#modalItem').val();
            $('#tax_' + itemId).text((toNumber($('#ptx').text()) * $('#pQty').val()).format(2));
            $('#p_tax_' + itemId).text((toNumber($('#ptx').text())).format(2));
            $('#quantity_' + itemId).val($('#pQty').val());
            $('#unit_' + itemId).val(toNumber($('#pUnit').val()));
            $('#costPrice_' + itemId).text($('#nucost').text());
            $('#discount_' + itemId).text(($('#pDisco').val() * $('#pQty').val()).format(2));
            qtyChanging(itemId)
            $('#itemDetails').modal('toggle');

        }

    </script>
@endsection
