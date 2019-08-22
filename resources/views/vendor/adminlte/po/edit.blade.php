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
                <h3 class="box-title">Edit Purchase Order</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                            title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <form role="form" id="pocreate" enctype="multipart/form-data" action="{{url('po/edit/'.$po->id)}}"
                  method="post">
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
                                               value="{{$po->due_date}}"
                                               class="form-control pull-right" id="datepicker">
                                    </div>
                                    <!-- /.input group -->
                                    <p class="help-block" id="datepicker_error"></p>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Status *</label>

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-hourglass-end"></i>
                                        </div>
                                        <select class="form-control select2" name="status" id="status">
                                            <option value="0" {{ ($po->status== 0? "selected":"") }}>Select
                                                Status
                                            </option>
                                            <option value="1" {{ ($po->status== 1? "selected":"") }}>Received
                                            </option>
                                            <option value="2" {{ ($po->status== 2? "selected":"") }}>Ordered
                                            </option>
                                            <option value="3" {{ ($po->status== 3? "selected":"") }}>Pending
                                            </option>

                                        </select>
                                    </div>
                                    <!-- /.input group -->
                                    <p class="help-block" id="status_error"></p>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Location *</label>

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-location-arrow"></i>
                                        </div>
                                        <select class="form-control select2" name="location" id="location">
                                            <option value="0">Select Location</option>
                                            @foreach($locations as $location)
                                                <option value="{{  $location->id}}" {{ ($po->location == $location->id? "selected":"")}}>{{$location->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- /.input group -->
                                    <p class="help-block" id="location_error"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Reference No</label>

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-barcode"></i>
                                        </div>
                                        <input type="text" class="form-control" name="referenceNo" id="referenceNo"
                                               readonly
                                               value="{{$po->referenceCode}}">
                                    </div>
                                    <!-- /.input group -->
                                    <p class="help-block" id="referenceNo_error"></p>
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
                                        <i class="fa fa-user-secret"></i>
                                    </div>
                                    <input type="hidden" name="supplier" id="supplier" value="{{$po->supplier}}">
                                    <input type="hidden" name="deletedItems[]" id="deletedItems">
                                    <select class="form-control col-xs-4 select2"
                                            disabled="true">
                                        <option value="0">Select Supplier</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{$supplier->id}}" {{($po->supplier== $supplier->id? "selected":"")}}>{{$supplier->name}}</option>
                                        @endforeach

                                    </select>

                                </div>
                                <p class="help-block" id="supplier_error"></p>
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
                    <?php
                    //                            echo '<pre>';
                    //                        print_r($po->poDetails);
                    //                        echo '</pre>';
                    ?>
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
                            @foreach($po->poDetails as $poItem)

                                <tr id="row_deletable_{{ $poItem->id }}" style="text-align: right">
                                    <td style="text-align: left">{{ $poItem->product->name }}
                                        ( {{ $poItem->product->item_code }} )<i
                                                class="fa fa-edit" onclick='itemDetails({{ $poItem->item_id }})'
                                                style='float: right;cursor: pointer'></i></td>
                                    <td id='costPrice_{{ $poItem->item_id }}'>{{ $poItem->cost_price }}</td>
                                    <td style="text-align: center"><input type='text' style="text-align: center"
                                                                          class='qy'
                                                                          onkeyup='qtyChanging({{ $poItem->item_id }})'
                                                                          id='quantity_{{ $poItem->item_id }}'
                                                                          value='{{ $poItem->qty }}'></td>
                                    <td id='discount_{{ $poItem->item_id }}'>{{number_format($poItem->discount,2)}}</td>
                                    <td hidden id='hidden_data_{{ $poItem->item_id }}'>

                                        <input type='hidden' name='discount[]' id='discount_h{{ $poItem->item_id }}' value='{{($poItem->discount)}}'>
                                        <input type='hidden' name='quantity[]' id='quantity_h{{ $poItem->item_id }}' value='{{ $poItem->qty }}'>
                                        <input type='hidden' name='costPrice[]' id='costPrice_h{{ $poItem->item_id }}' value='{{ ($poItem->cost_price) }}'>
                                        <input type='hidden' name='item[]' id='item_h{{ $poItem->item_id }}' value='{{ $poItem->item_id }}'>
                                        <input type='hidden' name='unit[]' id='unit_h{{ $poItem->item_id }}'>
                                        <input type='hidden' name='p_tax[]' id='p_tax_h{{ $poItem->item_id }}' value='{{ $poItem->tax_val }}'>
                                        <input type='hidden' name='subtot[]' id='subtot_h{{ $poItem->item_id }}' value='{{ $poItem->sub_total }}'>
                                        <input type='hidden' name='tax_id[]' id='tax_id_h{{ $poItem->item_id }}' value="{{ $poItem->tax_percentage }}">


                                    </td>
                                    <td class='tax'
                                        id='tax_{{ $poItem->item_id }}'>{{ number_format($poItem->tax_val,2)}}</td>
                                    <td class='subtot'
                                        id='subtot_{{ $poItem->item_id }}'>{{ number_format($poItem->sub_total,2) }}</td>
                                    <td style="text-align: center"><i class="glyphicon glyphicon-remove"
                                                                      onclick="deleteThis({{ $poItem->id }})"
                                                                      style="cursor: pointer"></i></td>
                                </tr>

                            @endforeach


                            </tbody>
                        </table>
                    </div>
                    <p class="help-block" id="items_error"></p>
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
                                                <i class="fa fa-circle"></i>
                                            </div>
                                            <select class="form-control select2" name="wholeTax" id="wholeTax"
                                                    onchange="lastRowDesign()">
                                                <option value="0">Select tax</option>
                                                @foreach($tax as $ta)
                                                    <option value="{{$ta->value}}" {{($po->tax_percentage==$ta->value? "selected":"")}}>{{$ta->name ."-".$ta->code}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <!-- /.input group -->
                                        {{--                                        <p class="help-block" id="datepicker_error"></p>--}}
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Discount (5/5%)</label>

                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-circle"></i>
                                            </div>
                                            <input type="text" class="form-control" name="wholeDiscount"
                                                   value="{{$po->discount_val_or_per}}"
                                                   id="wholeDiscount" onkeyup="lastRowDesign()">
                                        </div>
                                        <!-- /.input group -->
                                        {{--                                        <p class="help-block" id="datepicker_error"></p>--}}
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Note</label>

                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-sticky-note"></i>
                                            </div>
                                            <textarea type="text" class="form-control" id="note" name="note"
                                                      placeholder="Note"
                                                      autocomplete="off">{{$po->remark}}</textarea>
                                        </div>
                                        <!-- /.input group -->
                                        {{--                                        <p class="help-block" id="datepicker_error"></p>--}}
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
            lastRowDesign()
            // itemsLoad()

            var options = {

                url: "/products/fetchProductsList/" + $('#supplier').val(),

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

            $("#product").keyup(function () {
                // $('#modal-danger').modal({
                //     show: 'true'
                // });
                // $("#product").val('')
                checkValuesExistsInProducts()
            });

            $("#supplier").change(function () {


            });


            $("#pocreate").unbind('submit').on('submit', function () {
                var form = $(this);

                var qtySum = 0;
                $('.qy').each(function () {
                    qtySum += toNumber($(this).val());  // Or this.innerHTML, this.innerText
                });

                if (($('#poTable tr').length - 2) < 1) {
                    $('#items_error').html('Items required');
                    return false
                } else if (qtySum < 1) {
                    $('#items_error').html('Fill Items Qty required');
                    return false
                }

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(), // /converting the form data into array and sending it to server
                    dataType: 'json',
                    success: function (response) {
                        // window.location = data;
                        console.log(response)
                        if (response.success) {
                            window.location.href = '/po/manage';
                        }


                    },
                    error: function (request, status, errorThrown) {

                        $('.help-block').html('');
                        if (typeof request.responseJSON.errors.datepicker !== 'undefined') {
                            $('#datepicker_error').html(request.responseJSON.errors.datepicker[0]);
                        }
                        if (typeof request.responseJSON.errors.status !== 'undefined') {
                            $('#status_error').html(request.responseJSON.errors.status[0]);
                        }
                        if (typeof request.responseJSON.errors.location !== 'undefined') {
                            $('#location_error').html(request.responseJSON.errors.location[0]);
                        }
                        if (typeof request.responseJSON.errors.referenceNo !== 'undefined') {
                            $('#referenceNo_error').html(request.responseJSON.errors.referenceNo[0]);
                        }
                        if (typeof request.responseJSON.errors.supplier !== 'undefined') {
                            $('#supplier_error').html(request.responseJSON.errors.supplier[0]);
                        }


                    }

                });
                return false;
            })


        });

        {{--function itemsLoad() {--}}
        {{--    $.ajax('/products/fetchProductDataById', {--}}
        {{--        type: 'post',  // http method--}}
        {{--        data: {--}}
        {{--            id: id,--}}
        {{--            "_token": "{{ csrf_token() }}",--}}
        {{--        },--}}
        {{--        success: function (data, status, xhr) {--}}


        {{--        }--}}
        {{--    })--}}
        {{--}--}}
        //
        function checkValuesExistsInProducts() {
            var containerList = $('#product').next('.easy-autocomplete-container').find('ul');
            if ($(containerList).children('li').length <= 0) {
                $(containerList).html('<li>No results found</li>').show();
            }
        }


        function changeProduct(index) {
            // localStorage.clear();
            if (document.getElementById("quantity_" + index.id) === null) {
                localStorage.setItem('item', JSON.stringify(index.id));

                var taxval = (toNumber(toNumber(index.cost_price * toNumber(index.tax)) / (100 + toNumber(index.tax)))).format(2);
                var cost = (index.cost_price - taxval).format(2);

                var row = '<tr id="row_' + index.id + '" style="text-align: right">' +
                    "<td style=\"text-align: left\">" + index.name + "( " + index.item_code + " )" + "  <i  class=\"fa fa-edit\" onclick='itemDetails(" + index.id + ")' style='float: right;cursor: pointer'></i></td>" +
                    "<td id='costPrice_" + index.id + "'>" + cost + "</td>" +
                    "<td style=\"text-align: center\"><input type='text'   style=\"text-align: center\" class='qy' onkeyup='qtyChanging(" + index.id + ")' id='quantity_" + index.id + "' value='" + 1 + "'></td>" +
                    "<td id='discount_" + index.id + "'>" + index.discount + "</td>" +
                    "<td hidden id='hidden_data_" + index.id + "'>" +

                    "<input type='hidden' name='discount[]' id='discount_h" + index.id + "' value='0'>" +
                    "<input type='hidden' name='quantity[]' id='quantity_h" + index.id + "' value='" + 0 + "'>" +
                    "<input type='hidden' name='costPrice[]' id='costPrice_h" + index.id + "' value='" + index.cost_price + "'>" +
                    "<input type='hidden' name='item[]' id='item_h" + index.id + "' value='" + index.id + "''>" +
                    "<input type='hidden' name='unit[]' id='unit_h" + index.id + "' value='1'>" +
                    "<input type='hidden'  name='p_tax[]' id='p_tax_h" + index.id + "'  value='" + taxval + "'>" +
                    "<input type='hidden'  name='subtot[]' id='subtot_h" + index.id + "'>" +
                    "<input type='hidden'   name='tax_id[]' id='tax_id_h" + index.id + "' value='" + index.tax + "'>" +

                    "</td>" +
                    "<td class='tax' id='tax_" + index.id + "'>" + taxval + "</td>" +
                    "<td class='subtot' id='subtot_" + index.id + "'>" + 0 + "</td>" +
                    '<td style="text-align: center"><i class="glyphicon glyphicon-remove" onclick="removeThis(' + index.id + ')" style="cursor: pointer"></i></td>';

                row += '</tr>';
                $('.lastRow').remove()
                $('#poBody').append(row);
                qtyChanging( index.id )
            }
        }

        function qtyChanging(id) {

            $('#tax_' + id).text((toNumber($('#p_tax_h' + id).val()) * $('#quantity_' + id).val()).format(2));
            var subTot = ((toNumber($('#costPrice_' + id).text()) * toNumber($('#quantity_' + id).val())) + toNumber(($('#tax_' + id).text())));
            $('#quantity_h' + id).val(toNumber($('#quantity_' + id).val()));
// alert($('#costPrice_' + id).text()+" == "+ $('#quantity_' + id).val()+" ==== "+$('#unit_' + id).val())
            $('#subtot_' + id).text(((!isNaN(subTot)) ? subTot : 0).format(2));
            $('#subtot_h' + id).val(toNumber((!isNaN(subTot)) ? subTot.format(2) : 0));

            lastRowDesign();
        }

        function lastRowDesign() {
            var sum = 0;
            $('.subtot').each(function () {
                sum += toNumber($(this).text());  // Or this.innerHTML, this.innerText
            });
            var qtySum = 0;
            $('.qy').each(function () {
                qtySum += toNumber($(this).val());  // Or this.innerHTML, this.innerText
            });

            var txSum = 0
            $('.tax').each(function () {
                txSum += toNumber($(this).text());  // Or this.innerHTML, this.innerText
            });
            var disco = 0
            $('.disco').each(function () {
                disco += toNumber($(this).text());  // Or this.innerHTML, this.innerText
            });


            var lastRow = '<tr class="lastRow" style="font-weight: bold;text-align: right">' +
                "<td colspan='3' style='text-align: left'>Total</td>" +
                "<td id='sumQuantity'>" + disco.format(2) + "</td>" +
                "<td id='sumDiscount'>" + txSum.format(2) + "</td>" +
                "<td id='sumTax' style='align:right'>" + sum.format(2) + "</td><td style='text-align: center'><i class=\"fa fa-trash\"></i></td></tr>";

            $('.lastRow').remove();
            $('#poBody').append(lastRow);

            var wdisco = (($('#wholeDiscount').val()).indexOf('%') > -1) ? toNumber(sum * $('#wholeDiscount').val().replace('%', '') / 100) : toNumber($('#wholeDiscount').val());
            var wtax = ((toNumber(sum - wdisco) * toNumber($('#wholeTax').val())) / 100);
            var gtot = (sum - wdisco) + wtax;
            // var gtot = taxdeductSum - wdisco;

            var footerRow = "<table class=\"table table-bordered\" ><tr style=\"font-weight: bold;text-align: right;color: #0d6aad\">" +
                "<td style='text-align: left;background-color: #dfe4da;width: 13%'>Items</td>" +
                "<td style='text-align: right;background-color: #c2c7bd;width: 7%'>" + ($('#poTable tr').length - 2) + " (" + qtySum + ") " + "</td>" +
                "<td style='text-align: left;background-color: #dfe4da;width: 13%'>Total</td>" +
                "<td style='text-align: right;background-color: #c2c7bd;width: 7%'>" + sum.format(2) + "</td>" +
                "<td style='text-align: left;background-color: #dfe4da;width: 13%'>Order Discount</td>" +
                "<td style='text-align: right;background-color: #c2c7bd;width: 7%'>" + wdisco.format(2) + "</td>" +
                "<td style='text-align: left;background-color: #dfe4da;width: 13%'>Order Tax</td>" +
                "<td style='text-align: right;background-color: #c2c7bd;width: 7%'>" + wtax.format(2) + "</td>" +
                "<td style='text-align: left;background-color: #dfe4da;width: 13%'>Grand Total</td>" +
                "<td style='text-align: right;background-color: #c2c7bd;width: 7%'>" +
                "<input type='hidden' name='grand_total' id='grand_total' value='" + toNumber(gtot.format(2)) + "'>" +
                "<input type='hidden' name='grand_tax_id' id='grand_tax_id' value='" + $('#wholeTax').val() + "'>" +
                "<input type='hidden' name='grand_discount' id='grand_discount' value='" + toNumber(wdisco) + "'>" +
                "<input type='hidden' name='grand_tax' id='grand_tax' value='" + toNumber(wtax) + "'>" + gtot.format(2) + "" +
                "</td><tr></table>";


            $('#footer').html(footerRow);
        }

        function removeThis(removeRow) {
            $('#row_' + removeRow).remove()
            lastRowDesign()
        }

        function deleteThis(removeItem) {
            $('#deletedItems').val(removeItem);
            $('#row_deletable_' + removeItem).remove()
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
                    // alert(toNumber($('#quantity_' + id).val()))
                    // if (toNumber($('#quantity_' + id).val()) > 0) {
                    //         $('#pCost').val((toNumber(toNumber($('#costPrice_' + id).text()) + (toNumber($('#tax_' + id).text()) / toNumber($('#quantity_' + id).val())) + (toNumber($('#discount_' + id).text()) / toNumber($('#quantity_' + id).val())))).format(2));
                    // } else {
                        $('#pCost').val(toNumber($('#costPrice_h' + id).val()))
                    // }


                    $('#itemName').text(item.name + " ( " + item.item_code + ") ");
                    $('#pQty').val($('#quantity_' + id).val());
                    $('#pDisco').val((toNumber(toNumber($('#discount_' + id).text()) / toNumber($('#quantity_' + id).val()))).format(2));

                    $("#pTax").select2("val", "0");
                    $("#pTax").val($('#tax_id_h' + id).val()).trigger('change');

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
            // $('#tax_' + itemId).text((toNumber($('#ptx').text()) * $('#pQty').val()).format(2));
            // $('#p_tax_h' + itemId).val(toNumber((toNumber($('#ptx').text()) * $('#pQty').val()).format(2)));

            $('#p_tax_h' + itemId).val((toNumber($('#ptx').text())).format(2));
            $('#tax_id_h' + itemId).val($('#pTax').val())

            $('#quantity_' + itemId).val($('#pQty').val());
            $('#quantity_h' + itemId).val($('#pQty').val());

            $('#unit_' + itemId).val(toNumber($('#pUnit').val()));
            $('#unit_h' + itemId).val(toNumber($('#pUnit').val()));

            $('#costPrice_' + itemId).text($('#nucost').text());
            $('#costPrice_h' + itemId).val($('#pCost').val());

            $('#discount_' + itemId).text(($('#pDisco').val() * $('#pQty').val()).format(2));
            $('#discount_h' + itemId).val(toNumber(($('#pDisco').val() * $('#pQty').val()).format(2)));
            qtyChanging(itemId)
            $('#itemDetails').modal('toggle');

        }


    </script>
@endsection
