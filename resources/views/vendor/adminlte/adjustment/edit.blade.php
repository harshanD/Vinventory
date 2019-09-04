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
        <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
        <li><a href="{{url('/adjustment/manage')}}">Adjustment Manage</a></li>
        <li class="active">Edit Adjustment</li>
    </ol>
@stop

@section('content')
    <style>
        select[readonly].select2 + .select2-container {
            pointer-events: none;
            touch-action: none;

        /*cursor: not-allowed;*/

        .select2-selection {
            background: #eee;
            box-shadow: none;
        }

        .select2-selection__arrow,
        .select2-selection__clear {
            display: none;
        }

        }
    </style>
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Adjustment</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                            title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <form role="form" id="adjUpdate" enctype="multipart/form-data"
                  action="{{url('adjustment/edit/'.$adjustment->id)}}"
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
                                    <label>Date<span class="mandatory"> *</span></label>

                                    <div class="input-group date">
                                        <input type="hidden" name="deletedItems[]" id="deletedItems">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" placeholder="Select Date" name="datepicker"
                                               value="{{$adjustment->date}}"
                                               class="form-control pull-right" id="datepicker">
                                    </div>
                                    <!-- /.input group -->
                                    <p class="help-block" id="datepicker_error"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Reference No<span class="mandatory"> *</span></label>

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-barcode"></i>
                                        </div>
                                        <input type="text" class="form-control" name="referenceNo" id="referenceNo"
                                               readonly
                                               value="{{$adjustment->reference_code}}">
                                    </div>
                                    <!-- /.input group -->
                                    <p class="help-block" id="referenceNo_error"></p>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Warehouse<span class="mandatory"> *</span></label>

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-location-arrow"></i>
                                        </div>
                                        <select class="form-control select2" name="location" id="location">
                                            <option value="0">Select Warehouse</option>
                                            @foreach($locations as $location)
                                                <option value="{{  $location->id}}" {{ ($adjustment->location == $location->id? "selected":"")}}>{{$location->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- /.input group -->
                                    <p class="help-block" id="location_error"></p>
                                </div>
                            </div>

                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

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
                                <th>Type</th>
                                <th>Quantity</th>
                                <th hidden>Serial Number</th>
                                <th style="text-align:center"><i class="fa fa-trash"></i></th>
                            </tr>
                            </thead>
                            <tbody id="poBody">
                            <?php
                            echo '<pre>';
                            //                            print_r());
                            //                            echo '</pre>';
                            ?>
                            @isset($added->stockItems)
                                @foreach($added->stockItems as $addsItem)

                                    <tr id="row_{{ $addsItem->item_id }}" style="text-align: right">
                                        <td style="text-align: left">
                                            {{ $addsItem->products->name }}
                                            ( {{ $addsItem->products->item_code }} )

                                        </td>
                                        <td><select style="width: 100%;" class="form-control select2" readonly
                                                    name='type[]'>
                                                <option value='A' selected>Addition</option>
                                                <option value='S'>Subtraction</option>
                                            </select></td>
                                        <td style="text-align: center"><input type='text' style="text-align: center"
                                                                              class='qy number'
                                                                              name="quantity[]"
                                                                              id='quantity_{{ $addsItem->item_id }}'
                                                                              value='{{ $addsItem->qty }}'></td>
                                        <td hidden id='hidden_data_{{ $addsItem->item_id }}'>
                                            <input type='hidden' name='item[]' id='item_h{{ $addsItem->item_id }}'
                                                   value='{{ $addsItem->item_id }}'>
                                        </td>
                                        <td style="text-align: center"><i class="glyphicon glyphicon-remove"
                                                                          onclick="deleteThis({{ $addsItem->item_id }})"
                                                                          style="cursor: pointer"></i></td>
                                    </tr>

                                @endforeach
                            @endisset
                            {{--substract--}}
                            @isset($subs->stockItems)
                                @foreach($subs->stockItems as $subsItem)

                                    <tr id="row_{{ $subsItem->item_id }}" style="text-align: right">
                                        <td style="text-align: left">{{ $subsItem->products->name }}
                                            ( {{ $subsItem->products->item_code }} )
                                        </td>
                                        <td><select style="width: 100%;" class="form-control select2" readonly
                                                    name='type[]'>
                                                <option value='A'>Addition</option>
                                                <option value='S' selected>Subtraction</option>
                                            </select></td>
                                        <td style="text-align: center"><input type='text' style="text-align: center"
                                                                              class='qy number'
                                                                              name="quantity[]"
                                                                              value='{{ $subsItem->qty }}'></td>
                                        <td hidden id='hidden_data_{{ $subsItem->item_id }}'>
                                            <input type='hidden' name='item[]'
                                                   value='{{ $subsItem->item_id }}'>
                                        </td>
                                        <td style="text-align: center"><i class="glyphicon glyphicon-remove"
                                                                          onclick="deleteThis({{ $subsItem->item_id }})"
                                                                          style="cursor: pointer"></i></td>
                                    </tr>

                                @endforeach
                            @endisset

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
                                        <label>Note</label>

                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-sticky-note"></i>
                                            </div>
                                            <textarea type="text" class="form-control" id="note" name="note"
                                                      placeholder="Note"
                                                      autocomplete="off">{{$adjustment->note}}</textarea>
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
                            <a onclick="window.history.back()" class="btn btn-warning">Back</a>
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


        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
        </div>

    </section>

    <script>


        var autoCompleteId = 'product';
        var acurl = '';

        $(document).ready(function () {

            // itemsLoad()

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


            $("#adjUpdate").unbind('submit').on('submit', function () {
                var form = $(this);

                var qtySum = 0;
                $('.qy').each(function () {
                    qtySum += toNumber($(this).val());  // Or this.innerHTML, this.innerText
                });

                if (($('#poTable tr').length - 1) < 1) {
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
                            window.location.href = '/adjustment/manage';
                        }


                    },
                    error: function (request, status, errorThrown) {

                        $('.help-block').html('');
                        if (typeof request.responseJSON.errors.datepicker !== 'undefined') {
                            $('#datepicker_error').html(request.responseJSON.errors.datepicker[0]);
                        }
                        if (typeof request.responseJSON.errors.location !== 'undefined') {
                            $('#location_error').html(request.responseJSON.errors.location[0]);
                        }
                        if (typeof request.responseJSON.errors.referenceNo !== 'undefined') {
                            $('#referenceNo_error').html(request.responseJSON.errors.referenceNo[0]);
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
            if (document.getElementById("row_" + index.id) === null) {
                localStorage.setItem('item', JSON.stringify(index.id));


                var row = '<tr id="row_' + index.id + '" style="text-align: right">' +
                    "<td style=\"text-align: left\">" + index.name + "( " + index.item_code + " )" + "  </td>" +
                    "<td id='costPrice_" + index.id + "'><select  class=\"form-control select2\" name='type[]' ><option value='A'>Addition</option><option value='S'>Subtraction</option></select></td>" +
                    "<td style=\"text-align: center\"><input type='text'   style=\"text-align: center\" class='qy number' name='quantity[]' onkeyup='qtyChanging(" + index.id + ")' id='quantity_" + index.id + "' value='" + 1 + "'>" +
                    "<input type='hidden' name='item[]' id='item_h" + index.id + "' value='" + index.id + "''>" +
                    "</td>" +
                    '<td style="text-align: center"><i class="glyphicon glyphicon-remove" onclick="removeThis(' + index.id + ')" style="cursor: pointer"></i></td>';

                row += '</tr>';
                $('.lastRow').remove()
                $('#poBody').append(row);
                qtyChanging(index.id)
            }
        }

        function qtyChanging(id) {
            qtyValidating('quantity_'+id);
            $('#tax_' + id).text((toNumber($('#p_tax_h' + id).val()) * $('#quantity_' + id).val()).format(2));
            var subTot = ((toNumber($('#costPrice_' + id).text()) * toNumber($('#quantity_' + id).val())) + toNumber(($('#tax_' + id).text())));
            $('#quantity_h' + id).val(toNumber($('#quantity_' + id).val()));
            $('#discount_' + id).text(($('#pDisco_h' + id).val() * toNumber($('#quantity_' + id).val())));
            $('#discount_h' + id).val(toNumber(($('#pDisco_h' + id).val() * toNumber($('#quantity_' + id).val()))));
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

            var footerRow = "<div class='table-responsive'><table class=\"table table-bordered\" ><tr style=\"font-weight: bold;text-align: right;color: #0d6aad\">" +
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
                "</td><tr></table></div>";


            $('#footer').html(footerRow);
        }

        function removeThis(removeRow) {
            $('#row_' + removeRow).remove()
            lastRowDesign()
        }

        function deleteThis(removeItem) {
            $('#deletedItems').val(removeItem);
            $('#row_' + removeItem).remove()
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


            $('#pDisco_h' + itemId).val($('#pDisco').val());
            $('#discount_' + itemId).text(($('#pDisco').val() * $('#pQty').val()).format(2));
            $('#discount_h' + itemId).val(toNumber(($('#pDisco').val() * $('#pQty').val()).format(2)));
            qtyChanging(itemId)
            $('#itemDetails').modal('toggle');

        }


    </script>
@endsection
