<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">VIEW PAYMENTS ({{ $headerCode }})</h4>
        </div>

        <form role="form" id="poPartiallyReceivedForm" enctype="multipart/form-data">
            <div class="modal-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Reference No</th>
                        <th>Amount</th>
                        <th>Paid by</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($payments)>0)
                        @foreach($payments as $payment)
                            <tr>
                                <td>{{$payment->date}}</td>
                                <td>{{$payment->reference_code}}</td>
                                <td>{{number_format($payment->value,2)}}</td>
                                <td>{{$payment->pay_type}}</td>
                                <td>
                                    <button type="button" class="btn btn-default"
                                            onclick="editPayment( {{$payment->id}} {{','. "'".$type."'"}})"
                                            data-toggle="modal" data-target="#editTaxModal"><i class="fa fa-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-default"
                                            onclick="deletePayment({{$payment->id}}{{','. "'".$type."'"}})"
                                            data-toggle="modal"
                                            data-target="#removeTaxModal"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                        @else
                        <tr><td colspan="5" style="text-align: center">No Payments</td></tr>
                        @endif
                    </tbody>
                </table>

            </div>

        </form>


    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<div class="modal fade" tabindex="-1" role="dialog" id="paymentsDelete">
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
                    <a class="btn btn-primary" href="" role="button" id="paymentDeleteBtn">Delete</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </form>


        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<script>

    function editPayment(id, type) {
        $.ajax({
            url: '/payments/paymentEditShow',
            type: 'POST',
            data: {
                'payment_id': id,
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

    function deletePayment(id, type) {
        $('#paymentsDelete').modal({
            hidden: 'true'
        });

        $('#paymentDeleteBtn').attr("href", ('/payment/delete/') + id);
    }
</script>


