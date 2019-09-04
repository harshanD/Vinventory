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
        <li class="active">Add Adjustment</li>
    </ol>
@stop

@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Add Adjustment</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                            title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <form role="form" id="pocreate" enctype="multipart/form-data" action="{{url('adjustment/create')}}"
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
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" placeholder="Select Date" name="datepicker"
                                               value="{{date('Y-m-d')}}" class="form-control pull-right"
                                               id="datepicker">
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
                                               value="{{$lastRefCode}}">
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
                                                <option value="{{$location->id}}">{{$location->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- /.input group -->
                                    <p class="help-block" id="location_error"></p>
                                </div>
                            </div>

                            <!-- /.col -->
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
                                <th>Type</th>
                                <th>Quantity</th>
                                <th hidden>Serial Number</th>
                                <th style="text-align:center"><i class="fa fa-trash"></i></th>
                            </tr>
                            </thead>
                            <tbody id="poBody">


                            </tbody>
                        </table>
                    </div>
                    <p class="help-block" id="items_error"></p>
                    {{--                    <p class="help-block" id="grand_tax_id"></p>--}}
                    <div class="box-body">

                        <!-- /.box -->
                    </div>
                    <div class="box-body">
                        <div id="collapseOptions" class="collapse">
                            <div class="row">
                                <div class="col-md-4" hidden>
                                    <div class="form-group">
                                        <label>Order Tax</label>

                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-circle"></i>
                                            </div>
                                            <select class="form-control select2" name="wholeTax" id="wholeTax"
                                                    onchange="lastRowDesign()">
                                                <option value="0">Select tax</option>


                                            </select>
                                        </div>
                                        <!-- /.input group -->
                                        {{--                                        <p class="help-block" id="datepicker_error"></p>--}}
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-4" hidden>
                                    <div class="form-group">
                                        <label>Discount (5/5%)</label>

                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-circle"></i>
                                            </div>
                                            <input type="text" class="form-control" name="wholeDiscount" value="0"
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
                                                      autocomplete="off"></textarea>
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
                                    <label for="inputPassword3" class="col-sm-3 control-label">Unit Cost (Rs)</label>

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

                                    <th style="width: 25%">Net Unit Cost (Rs)</th>
                                    <th style="width: 25%" id="nucost"></th>
                                    <th style="width: 25%">Product Tax</th>
                                    <th style="width: 25%" id="ptx"></th>

                                    </thead>
                                </table>
                                <br>
                                <div class="panel panel-default">
                                    <div class="panel-heading">Calculate Unit Cost (Rs)</div>
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
            });


            $("#pocreate").unbind('submit').on('submit', function () {
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
        //
        // function checkValuesExistsInProducts() {
        //     var containerList = $('#product').next('.easy-autocomplete-container').find('ul');
        //     if ($(containerList).children('li').length <= 0) {
        //         $(containerList).html('<li>No results found</li>').show();
        //     }
        // }


        function changeProduct(index) {
            // localStorage.clear();
            if (document.getElementById("row_" + index.id) === null) {
                localStorage.setItem('item', JSON.stringify(index.id));

                var row = '<tr id="row_' + index.id + '" style="text-align: right">' +
                    "<td style=\"text-align: left\">" + index.name + "( " + index.item_code + " )" + "  </td>" +
                    "<td id='costPrice_" + index.id + "'><select  class=\"form-control select2\" name='type[]' ><option value='A'>Addition</option><option value='S'>Subtraction</option></select></td>" +
                    "<td style=\"text-align: center\"><input type='text'   style=\"text-align: center\" class='qy' name='quantity[]' onkeyup='qtyChanging(" + index.id + ")' id='quantity_" + index.id + "' value='" + 1 + "'>" +
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

        }


        function removeThis(removeRow) {
            $('#row_' + removeRow).remove()
            lastRowDesign()
        }


    </script>
@endsection
