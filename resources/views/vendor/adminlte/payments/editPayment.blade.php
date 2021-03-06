<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">EDIT PAYMENT</h4>
        </div>

        <form action="{{url('payments/edit')}}" data-toggle="validator" role="form" id="paymentsEditForm"
              enctype="multipart/form-data"
              method="post" accept-charset="utf-8" novalidate="novalidate" class="bv-form">
            <input type="hidden" name="id" value="{{$payment->id}}">
            <input type="hidden" value="{{$type}}" name="type" id="type">
            <button type="submit" class="bv-hidden-submit"
                    style="display: none; width: 0px; height: 0px;"></button>
            {{@csrf_field()}}
            <div class="modal-body">
                <p>Please fill in the information below. The field labels marked with <span class="mandatory"> *</span> are required input
                    fields.</p>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group has-feedback">
                            <label for="date">Date <span class="mandatory"> *</span></label>
                            <input type="text" name="datepicker" value="{{$payment->date}}"
                                   class="form-control" id="datepicker2"
                            >
                            <p class="help-block" id="error_date_p"></p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="reference_no">Reference No<span class="mandatory"> *</span></label>
                            <input type="text" name="reference_no" value="{{$payment->reference_code}}"
                                   class="form-control tip"
                                   id="reference_no">
                            <p class="help-block" id="error_reference_no_p"></p>
                        </div>
                    </div>

                    <input type="hidden" name="parent_reference_code" id="parent_reference_code"
                           value="{{$payment->parent_reference_code}}">
                </div>
                <div class="clearfix"></div>
                <div id="payments">

                    <div class="well well-sm well_1">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="payment">
                                        <div class="form-group has-feedback">
                                            <label for="amount_1">Amount <span class="mandatory"> *</span></label> <input name="amount"
                                                                                          type="text"
                                                                                          value="{{$payment->value}}"
                                                                                          id="amount"
                                                                                          class="pa form-control kb-pad amount number"
                                                                                          data-bv-field="amount-paid">
                                            <i class="form-control-feedback" data-bv-icon-for="amount-paid"
                                               style="display: none;"></i>
                                            <p class="help-block" id="error_amount_p"></p>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="reference_no">Paying by <span class="mandatory"> *</span></label>
                                    <div class="form-group has-feedback">
                                        <select name="paid_by" id="paid_by" class="form-control paid_by"
                                                required="required" data-bv-field="paid_by" tabindex="-1"
                                                title="Paying by *">
                                            <option value="cash" {{($payment->pay_type == 'cash')?'selected':''}}>Cash
                                            </option>
                                            <option value="cheque" {{($payment->pay_type == 'cheque')?'selected':''}}>
                                                Cheque
                                            </option>
                                            <option value="other" {{($payment->pay_type == 'other')?'selected':''}}>
                                                Other
                                            </option>
                                        </select>

                                    </div>
                                </div>

                            </div>
                            <div class="clearfix"></div>

                            <div class="pcheque"
                                 style="visibility: {{($payment->pay_type != 'cheque')?'hidden':'visible'}}">
                                <div class="form-group"><label for="cheque_no_1">Cheque No</label>
                                    <input name="cheque_no" type="text" id="cheque_no" value="{{$payment->cheque_no}}"
                                           class="form-control cheque_no">
                                    <p class="help-block" id="error_cheque_no_p"></p>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                </div>


                <div class="form-group">
                    <label for="note">Note</label>


                    <textarea name="note" cols="40" rows="10" class="form-control" id="note" dir="ltr"
                    >{{$payment->note}}</textarea>

                </div>

            </div>
            <div class="modal-footer">
                <input type="submit" name="add_payment" value="Update Payment" class="btn btn-primary">
            </div>
        </form>


    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script>
    $(document).ready(function () {
        $("#paymentsEditForm").unbind('submit').on('submit', function () {

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
                    if ($('#type').val() == 'PO') {
                        window.location.href = '/po/manage';
                    } else if ($('#type').val() == 'IV') {
                        window.location.href = '/sales/manage';
                    }
                    // }


                },
                error: function (request, status, errorThrown) {

                    $('.help-block').html('');
                    if (typeof request.responseJSON.errors.datepicker !== 'undefined') {
                        $('#error_date_p').html(request.responseJSON.errors.datepicker[0]);
                    }
                    if (typeof request.responseJSON.errors.reference_no !== 'undefined') {
                        $('#error_reference_no_p').html(request.responseJSON.errors.reference_no[0]);
                    }
                    if (typeof request.responseJSON.errors.amount !== 'undefined') {
                        $('#error_amount_p').html(request.responseJSON.errors.amount[0]);
                    }
                    if (typeof request.responseJSON.errors.cheque_no !== 'undefined') {
                        $('#error_cheque_no_p').html(request.responseJSON.errors.cheque_no[0]);
                    }

                }

            });
            return false;
        })


        $('#paid_by').bind('change', function () {
            if (this.value == 'cheque') {
                $(".pcheque").css("visibility", "visible");
            } else {
                $(".pcheque").css("visibility", "hidden");
            }
        })
    })
</script>