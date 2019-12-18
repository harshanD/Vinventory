<?php
/**
 * Created by PhpStorm.
 * User: harshan
 * Date: 3/27/19
 * Time: 3:32 AM
 */
?>
@extends('adminlte::page')

@section('title', 'V-Inventory')

@section('content_header')
    <ol class="breadcrumb">
        <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Manage PO</li>
    </ol>
@stop

@section('content')
    <link rel="stylesheet" href="{{asset('/custom')}}/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Purchases</h3>

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
                <div class="<?= $table_responsive ?>">
                    <table id="poTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Reference No</th>
                            <th>Supplier</th>
                            <th>Reserved status</th>
                            <th>Grand Total</th>
                            <th>Paid</th>
                            <th>Balance</th>
                            <th>Payment Status</th>
                            <th>Actions</th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <a href="" class="btn btn-default"><i class="fa fa-edit"></i></a>
                                <a href="" class="btn btn-default"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>

                        </tbody>
                    </table>

                </div>
            </div>

            <!-- /.box-body -->
        {{--<div class="box-footer">--}}
        {{--Footer--}}
        {{--</div>--}}
        <!-- /.box-footer-->
        </div>

        <!-- /.box -->

        <!-- remove location modal -->
        <div class="modal fade" tabindex="-1" role="dialog" id="poReceivedModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Receive All</h4>
                    </div>

                    <form role="form" action="{{ url('po/receiveAll') }}" method="post" id="poReceivedForm">
                        <div class="modal-body">
                            {{csrf_field()}}
                            <input type="hidden" name="poId" class="poId">
                            <div class="form-group">
                                <label for="edit_location_name">Purchase Receive<span
                                            class="mandatory"> *</span></label>
                                <input type="text" class="form-control recNo" name="recNo"
                                       placeholder="Purchase Receive Code" autocomplete="off">
                                <p class="help-block" id="error_recNo_a"></p>
                            </div>
                            <div class="form-group">
                                <label for="edit_location_name">Receive Date<span class="mandatory"> *</span></label>
                                <input type="text" placeholder="Select Date" name="datepicker"
                                       value="{{date('Y-m-d')}}"
                                       class="form-control pull-right" id="datepicker">
                                <p class="help-block" id="error_datepicker_a"></p>
                            </div>
                            <div class="form-group">
                                <label for="edit_location_name">Notes</label>
                                <textarea type="text" class="form-control" id="note" name="note"
                                          placeholder="Note"
                                          autocomplete="off"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>


                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


        <!-- remove supplier modal -->
        <div class="modal fade" tabindex="-1" role="dialog" id="recConditonalProductModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">proceed confirm</h4>
                    </div>

                    <form id="recConditonalProductForm">
                        <div class="modal-body">
                            <p>This action will mark all the items as received. Do you really want to proceed?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" onclick="proceedReceiveAll()" class="btn btn-primary">Proceed</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>


                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


        <!-- remove location modal -->
        <div class="modal fade" tabindex="-1" role="dialog" id="poPartiallyReceivedModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Partially Receive</h4>
                    </div>

                    <form role="form" id="poPartiallyReceivedForm" enctype="multipart/form-data"
                          action="{{ url('po/partiallyReceive') }}" method="post"
                    >
                        <div class="modal-body">
                            {{csrf_field()}}
                            <input type="hidden" name="poId" class="poId">
                            <div class="form-group">
                                <label for="edit_location_name">Purchase Receive<span
                                            class="mandatory"> *</span></label>
                                <input type="text" class="form-control recNo" name="recNo"
                                       placeholder="Purchase Receive Code" autocomplete="off">
                                <p class="help-block" id="error_recNo"></p>
                            </div>
                            <div class="form-group">
                                <label for="edit_location_name">Receive Date<span class="mandatory"> *</span></label>
                                <input type="text" placeholder="Select Date" name="datepicker"
                                       value="{{date('Y-m-d')}}"
                                       class="form-control pull-right" id="datepicker1">
                                <p class="help-block" id="error_datepicker1"></p>
                            </div>

                            <div class="form-group">
                                <table class="table table-bordered">
                                    <thead>
                                    <th>Item</th>
                                    <th>Ordered</th>
                                    <th>Received</th>
                                    <th>Quantity to Receive</th>
                                    </thead>
                                    <tbody id="partialTable">
                                    {{--                                        @foreach()--}}
                                    </tbody>
                                </table>
                            </div>
                            <p class="help-block" id="items_error"></p>
                            <div class="form-group">
                                <label for="edit_location_name">Notes</label>

                                <textarea type="text" class="form-control" id="note" name="note"
                                          placeholder="Note"
                                          autocomplete="off"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>


                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!-- remove supplier modal -->
        <div class="modal fade" tabindex="-1" role="dialog" id="deleteProductModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Delete Confirm</h4>
                    </div>

                    <form id="deleteProductForm">
                        <div class="modal-body">
                            <p>Do you really want to remove?</p>
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-primary" href="" role="button" id="deleteBtn">Delete</a>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>


                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!--Payments module views -->
        <div class="modal fade" tabindex="-1" role="dialog" id="paymentsAddModal">

        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="paymentsEditModal">

        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="paymentsShow">

        </div>
        <!--Payments module views end -->


        {{--        --}}{{--email--}}
        {{--        <div class="modal fade" tabindex="-1" role="dialog" id="emailModal">--}}
        {{--            <div class="modal-dialog" role="document">--}}
        {{--                <div class="modal-content">--}}
        {{--                    <div class="modal-header">--}}
        {{--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span--}}
        {{--                                    aria-hidden="true">&times;</span></button>--}}
        {{--                        <h4 class="modal-title">Partially Receive</h4>--}}
        {{--                    </div>--}}

        {{--                    <form role="form" id="emailForm" enctype="multipart/form-data"--}}
        {{--                          action="{{ url('po/email') }}" method="post"--}}
        {{--                    >--}}
        {{--                        <div class="modal-body">--}}
        {{--                            {{csrf_field()}}--}}
        {{--                            <input type="hidden" name="poId" class="poId">--}}
        {{--                            <div class="form-group">--}}
        {{--                                <label for="edit_location_name">To<span class="mandatory"> *</span></label>--}}
        {{--                                <input type="text" class="form-control recNo" name="to" id="to"--}}
        {{--                                       placeholder="email" autocomplete="off">--}}
        {{--                                <p class="help-block" id="error_to"></p>--}}
        {{--                            </div>--}}
        {{--                            <div class="form-group">--}}
        {{--                                <label for="edit_location_name">Subject<span class="mandatory"> *</span></label>--}}
        {{--                                <input type="text" placeholder="Select Date" name="subject"--}}

        {{--                                       class="form-control pull-right" id="subject">--}}
        {{--                                <p class="help-block" id="error_datepicker"></p>--}}
        {{--                            </div>--}}


        {{--                            <p class="help-block" id="items_error"></p>--}}
        {{--                            <div class="form-group">--}}
        {{--                                <div class="box-body pad">--}}
        {{--                                    <label for="note">Message</label>--}}
        {{--                                    <textarea class="textarea" id="message" value="" name="message"--}}
        {{--                                              placeholder=""--}}
        {{--                                              style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>--}}
        {{--                                </div>--}}
        {{--                            </div>--}}
        {{--                        </div>--}}
        {{--                        <div class="modal-footer">--}}
        {{--                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
        {{--                            <button type="submit" class="btn btn-primary">Save changes</button>--}}
        {{--                        </div>--}}
        {{--                    </form>--}}


        {{--                </div><!-- /.modal-content -->--}}
        {{--            </div><!-- /.modal-dialog -->--}}
        {{--        </div><!-- /.modal -->--}}

    </section>
    <script src="{{asset('/custom')}}/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <script type="text/javascript">
        $('.textarea').wysihtml5()
        var manageTable;
        $(document).ready(function () {
            // $('[data-toggle="popover"]').popover();
            // table = $("table.table").dataTable();
            // table.fnPageChange("first", 1);
            // initialize the datatable
            manageTable = $('#poTable').DataTable({
                // ajax: '/po/fetchPOData',
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{!! route("fetchPOData") !!}",
                    type: 'get',
                },
                columns: [
                    {data: 'date'},
                    {data: 'referenceCode'},
                    {data: 'supplierName'},
                    {data: 'received_icon', orderable: false, searchable: false},
                    {data: 'grand_total'},
                    {data: 'paid'},
                    {data: 'balance'},
                    {data: 'status', orderable: false, searchable: false},
                    {data: 'action', name: 'actions', orderable: false, searchable: false}
                ],
                columnDefs: [
                    {
                        "targets": [4, 5, 6], // your case first column
                        "className": "text-right",
                    }, {
                        "targets": [0, 3, 7, 8], // your case first column
                        "className": "text-center",
                    }
                ],
            });


            $("#poPartiallyReceivedForm").unbind('submit').on('submit', function () {

                var form = $(this);

                var qtySum = 0;
                $('.qy').each(function () {
                    qtySum += toNumber($(this).val());  // Or this.innerHTML, this.innerText
                });

                if (qtySum < 1) {
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
                        // console.log(response)
                        // if (response.success) {
                        window.location.href = '/po/manage';
                        // }


                    },
                    error: function (request, status, errorThrown) {

                        $('.help-block').html('');
                        if (typeof request.responseJSON.errors.recNo !== 'undefined') {
                            $('#error_recNo').html(request.responseJSON.errors.recNo[0]);
                        }
                        if (typeof request.responseJSON.errors.datepicker !== 'undefined') {
                            $('#error_datepicker1').html(request.responseJSON.errors.datepicker[0]);
                        }

                    }

                });
                return false;
            })

            $("#poReceivedForm").unbind('submit').on('submit', function () {

                var form = $(this);

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(), // /converting the form data into array and sending it to server
                    dataType: 'json',
                    success: function (response) {
                        // window.location = data;
                        // console.log(response)
                        // if (response.success) {
                        window.location.href = '/po/manage';
                        // }
                    },
                    error: function (request, status, errorThrown) {

                        $('.help-block').html('');
                        if (typeof request.responseJSON.errors.recNo !== 'undefined') {
                            $('#error_recNo_a').html(request.responseJSON.errors.recNo[0]);
                        }
                        if (typeof request.responseJSON.errors.datepicker !== 'undefined') {
                            $('#error_datepicker_a').html(request.responseJSON.errors.datepicker[0]);
                        }

                    }

                });
                return false;
            })


        })

        function receiveAll(id) {
            $('.recNo').val($('#recNo_' + id).val());
            $('.poId').val(id);
            $('#recConditonalProductModal').modal({
                show: 'true'
            });
        }

        function proceedReceiveAll() {
            $('#recConditonalProductModal').modal('hide');

            $('#poReceivedModal').modal({
                hidden: 'true'
            });
        }

        function partiallyReceive(id) {
            // $('#recConditonalProductModal').modal('hide');
            $('.recNo').val($('#recNo_' + id).val());
            $('.poId').val(id);
            itemDetails(id)
            $('#poPartiallyReceivedModal').modal({
                hidden: 'true'
            });
        }

        function itemDetails(id) {
            $.ajax('/po/fetchPOItemsDataById', {
                type: 'post',  // http method
                data: {
                    id: id,
                    "_token": "{{ csrf_token() }}",
                },  // data to submit
                // beforeSend: function () {
                //     // $('#itemDetails').modal({
                //     //     show: 'true'
                //     // });
                //     // $('#modalItem').val(id)
                // },
                success: function (data, status, xhr) {
                    var item = JSON.parse(data);

                    var rows = '';
                    $('#partialTable').html('');
                    for (var i = 0; i < item.items.length; i++) {

                        rows += '<tr>' +
                            '<td>' + item.items[i].name + '</td>' +
                            '<td>' + item.items[i].qty + '</td>' +
                            '<td><input hidden name="poItemsId[]" value="' + item.items[i].id + '">' + item.items[i].received_qty + '</td>' +
                            '<td ><input hidden id="max_' + item.items[i].item_id + '"  value="' + toNumber(item.items[i].qty - item.items[i].received_qty) + '"><input type="text" style="text-align: center" value="0" class="qy" name="par_qty[]"  onkeyup="itemsQtyVali(' + item.items[i].item_id + ')" id="par_qty_' + item.items[i].item_id + '"></td>' +
                            '</tr>';
                    }
                    $('#partialTable').append(rows);

                },
                error: function (jqXhr, textStatus, errorMessage) {
                    $('p').append('Error' + errorMessage);
                }
            });
        }

        function itemsQtyVali(id) {
            // alert($.isNumeric($('#par_qty_' + id).val()));
            if (toNumber($('#par_qty_' + id).val()) > toNumber($('#max_' + id).val()) || !$.isNumeric($('#par_qty_' + id).val())) {
                $('#par_qty_' + id).css('background', 'red')
                $('#par_qty_' + id).val('')
                setTimeout(function () {
                    $('#par_qty_' + id).css('background', 'white')
                    $('#par_qty_' + id).val('0').focus
                }, 500);
            }
        }

        function deletePo(id) {
            $('#deleteProductModal').modal({
                hidden: 'true'
            });

            $('#deleteBtn').attr("href", ('/po/delete/') + id);
        }

        function mailView(id) {
            $('#emailModal').modal({
                hidden: 'true'
            });
        }

        function showPayments(id, type) {
            $.ajax({
                url: '/payments/paymentsShow',
                type: 'POST',
                data: {
                    'id': id,
                    'type': type,
                    '_token': '{{@csrf_token()}}',

                }, // /converting the form data into array and sending it to server
                dataType: 'json',
                success: function (response) {
                    $('#paymentsShow').html(response.html);
                    $('#paymentsShow').modal({
                        hidden: 'true'
                    });
                },
                error: function (request, status, errorThrown) {
                }
            });
        }

        function addPayments(id, type) {
            $.ajax({
                url: '/payments/paymentAddShow',
                type: 'POST',
                data: {
                    '_token': '{{@csrf_token()}}',
                    'id': id,
                    'type': type,

                }, // /converting the form data into array and sending it to server
                dataType: 'json',
                success: function (response) {
                    $('#paymentsAddModal').html(response.html);
                    $('#paymentsAddModal').modal({
                        hidden: 'true'
                    });
                },
                error: function (request, status, errorThrown) {
                }
            });
        }

        function approvePO(id) {
            $.ajax({
                url: '/po/approvePO',
                type: 'POST',
                data: {
                    '_token': '{{@csrf_token()}}',
                    'id': id,
                }, // /converting the form data into array and sending it to server
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        window.location.href = '/po/manage';
                    }
                },
                error: function (request, status, errorThrown) {
                }
            });
        }

    </script>
@endsection
