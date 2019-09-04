<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Payments;
use App\PO;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PaymentsController extends Controller
{
    public function addPayment(Request $request)
    {
        $request->validate([
            'datepicker' => 'required|date',
            'reference_no' => 'required|unique:payments,reference_code|max:100',
            'parent_reference_code' => 'required',
            'paid_by' => 'required',
            'amount' => 'required|numeric',
            'cheque_no' => ($request['paid_by'] == 'cheque') ? 'required|numeric' : '',
        ]);

        $payments = new Payments();
        $payments->reference_code = $request->input('reference_no');
        $payments->parent_reference_code = $request->input('parent_reference_code');
        $payments->value = $request->input('amount');
        $payments->date = $request->input('datepicker');
        $payments->pay_type = $request->input('paid_by');
        $payments->cheque_no = $request->input('cheque_no');
        $payments->note = $request->input('note');
        $payments->save();

        $totalPaid = $this->refCodeByGetOutstanding($request->input('parent_reference_code'));

        if ($request['type'] == 'PO') {
            $getSum = PO::where('referenceCode', $request->input('parent_reference_code'))->firstOrFail();
            $grand_total = $getSum->grand_total;
        } elseif ($request['type'] == 'IV') {
            $getSum = Invoice::where('invoice_code', $request->input('parent_reference_code'))->firstOrFail();
            $grand_total = $getSum->invoice_grand_total;
        }


        if ($grand_total < $totalPaid) {
            $getSum->payment_status = \Config::get('constants.i_payment_status_name.Over Paid');
        } elseif ($grand_total > $totalPaid) {
            $getSum->payment_status = \Config::get('constants.i_payment_status_name.Partial');
        } elseif ($grand_total == $totalPaid) {
            $getSum->payment_status = \Config::get('constants.i_payment_status_name.Paid');
        }


        if (!$getSum->save()) {
            $request->session()->flash('message', 'Error in the database while creating the Payment');
            $request->session()->flash('message-type', 'error');
        } else {
            $request->session()->flash('message', 'Successfully Payment Added ' . "[ Ref NO:" . $request->input('reference_no') . " ]");
            $request->session()->flash('message-type', 'success');
        }
        echo json_encode(array('success' => true));
    }

    public function editPayment(Request $request)
    {
        $id = $request['id'];

        $request->validate([
            'datepicker' => 'required|date',
            'reference_no' => 'required|unique:payments,reference_code,' . $id . '|max:100',
            'parent_reference_code' => 'required',
            'paid_by' => 'required',
            'amount' => 'required|numeric',
            'cheque_no' => ($request['paid_by'] == 'cheque') ? 'required|numeric' : '',
        ]);

        $payments = Payments::find($id);
        $payments->reference_code = $request->input('reference_no');
        $payments->parent_reference_code = $request->input('parent_reference_code');
        $payments->value = $request->input('amount');
        $payments->date = $request->input('datepicker');
        $payments->pay_type = $request->input('paid_by');
        $payments->cheque_no = $request->input('cheque_no');
        $payments->note = $request->input('note');
        $payments->save();

        $totalPaid = $this->refCodeByGetOutstanding($request->input('parent_reference_code'));

        if ($request['type'] == 'PO') {
            $getSum = PO::where('referenceCode', $request->input('parent_reference_code'))->firstOrFail();
            $grand_total = $getSum->grand_total;
        } elseif ($request['type'] == 'IV') {
            $getSum = Invoice::where('invoice_code', $request->input('parent_reference_code'))->firstOrFail();
            $grand_total = $getSum->invoice_grand_total;
        }

        if ($grand_total < $totalPaid) {
            $getSum->payment_status = \Config::get('constants.i_payment_status_name.Over Paid');
        } elseif ($grand_total > $totalPaid) {
            $getSum->payment_status = \Config::get('constants.i_payment_status_name.Partial');
        } elseif ($grand_total == $totalPaid) {
            $getSum->payment_status = \Config::get('constants.i_payment_status_name.Paid');
        }


        if (!$getSum->save()) {
            $request->session()->flash('message', 'Error in the database while update the Payment');
            $request->session()->flash('message-type', 'error');
        } else {
            $request->session()->flash('message', 'Successfully Payment updated ' . "[ Ref NO:" . $request->input('reference_no') . " ]");
            $request->session()->flash('message-type', 'success');
        }
        echo json_encode(array('success' => true));
    }

    public function refCodeByGetOutstanding($code)
    {
        $sum = Payments::where('parent_reference_code', $code)->sum('value');
        return $sum;
    }

    public function paymentsShow(Request $request)
    {
        if ($request['type'] == 'PO') {
            $parent = PO::find($request['id']);

            /*parent code (po , invoice )*/
            $parentCode = $parent->referenceCode;
            $type = 'Purchase Order ' . '- ' . $parentCode;
        } elseif ($request['type'] == 'IV') {

            $parent = Invoice::find($request['id']);

            /*parent code (po , invoice )*/
            $parentCode = $parent->invoice_code;
            $type = 'Sales ' . '- ' . $parentCode;
        }


        $payments = Payments::where('parent_reference_code', $parentCode)->get();
        $view = view('vendor.adminlte.payments.viewPayments', ['payments' => $payments, 'parent_reference_code' => $parentCode, 'headerCode' => $type, 'type' => $request['type']])->render();
        return response()->json(['html' => $view]);
    }

    public function paymentEditShow(Request $request)
    {
        $paymenId = $request['payment_id'];
        $payment = Payments::find($paymenId);

        $view = view('vendor.adminlte.payments.editPayment', ['payment' => $payment, 'type' => $request['type']])->render();
        return response()->json(['html' => $view]);
    }

    public function paymentAddShow(Request $request)
    {

        if ($request['type'] == 'PO') {
            $parent = PO::find($request['id']);
            $grand_total = $parent->grand_total;

            /*parent code (po , invoice )*/
            $parentCode = $parent->referenceCode;
        } elseif ($request['type'] == 'IV') {
            $parent = Invoice::find($request['id']);
            $grand_total = $parent->invoice_grand_total;

            /*parent code (po , invoice )*/
            $parentCode = $parent->invoice_code;
        }

        /*pending amount*/
        $pending = $this->refCodeByGetOutstanding($parentCode);
        $pendingAmount = $grand_total - $pending;

        /*last payment code get*/
        $lastPayRefCode = Payments::where('reference_code', 'like', '%P-%')->withTrashed()->get()->last();
        $codePayData = (isset($lastPayRefCode->reference_code)) ? $lastPayRefCode->reference_code : 'P-000000';
        $codePay = preg_replace_callback("|(\d+)|", "self::replace", $codePayData);

        $view = view('vendor.adminlte.payments.addPayment', ['pendingAmount' => $pendingAmount, 'parentCode' => $parentCode, 'type' => $request['type'], 'codePay' => $codePay])->render();
        return response()->json(['html' => $view]);
    }

    public function delete(Request $request)
    {
        $payment = Payments::find($request['id']);
        $payment->delete();
        if ($request['type'] == 'PO') {
            $getSum = PO::where('referenceCode', $request['parent_reference_code'])->firstOrFail();
            $grand_total = $getSum->grand_total;
        } elseif ($request['type'] == 'IV') {
            $getSum = Invoice::where('invoice_code', $request['parent_reference_code'])->firstOrFail();
            $grand_total = $getSum->invoice_grand_total;
        }

        $totalPaid = $this->refCodeByGetOutstanding($request['parent_reference_code']);

        if ($grand_total < $totalPaid) {
            $getSum->payment_status = \Config::get('constants.i_payment_status_name.Over Paid');
        } elseif ($grand_total > $totalPaid) {
            $getSum->payment_status = \Config::get('constants.i_payment_status_name.Partial');
        } elseif ($grand_total == $totalPaid) {
            $getSum->payment_status = \Config::get('constants.i_payment_status_name.Paid');
        }

        if (!$getSum->save()) {
            $request->session()->flash('message', 'Error in the database while deleting the Payment');
            $request->session()->flash('message-type', 'error');
        } else {
            $request->session()->flash('message', 'Payment Deleted');
            $request->session()->flash('message-type', 'success');
        }
        echo json_encode(array('success' => true));
    }
}
