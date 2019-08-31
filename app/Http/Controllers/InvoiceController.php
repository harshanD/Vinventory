<?php

namespace App\Http\Controllers;

use App\Biller;
use App\Customer;
use App\InvoiceDetails;
use App\Locations;
use App\Invoice;
use App\Mail\SendMailable;
use App\PO;
use App\PoDetails;
use App\Products;
use App\Stock;
use App\StockItems;
use App\Supplier;
use App\Tax;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth' => 'verified']);
    }

    public function index()
    {
        if (!Permissions::getRolePermissions('createSale')) {
            abort(403, 'Unauthorized action.');
        }
        $locations = Locations::where('status', \Config::get('constants.status.Active'))->get();
        $tax = Tax::where('status', \Config::get('constants.status.Active'))->get();
        $customers = Customer::where('status', \Config::get('constants.status.Active'))->get();
        $billers = Biller::where('status', \Config::get('constants.status.Active'))->get();
        $lastRefCode = Invoice::where('invoice_code', 'like', '%IV%')->withTrashed()->get()->last();
        $data = (isset($lastRefCode->invoice_code)) ? $lastRefCode->invoice_code : 'IV-' . '000000';

        $code = preg_replace_callback("|(\d+)|", "self::replace", $data);
        return view('vendor.adminlte.sales.create', ['locations' => $locations, 'tax' => $tax, 'lastRefCode' => $code, 'billers' => $billers, 'customers' => $customers]);
    }


    public function create(Request $request)
    {
        if (!Permissions::getRolePermissions('createSale')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'datepicker' => 'required|date',
            'referenceNo' => 'required|unique:invoice,invoice_code|max:100',
            'biller' => ['required', Rule::notIn(['0'])],
            'customer' => ['required', Rule::notIn(['0'])],
            'saleStatus' => ['required', Rule::notIn(['0'])],
            'location' => ['required', Rule::notIn(['0'])],
            'paymetStatus' => ['required', Rule::notIn(['0'])],
            'grand_tax_id' => 'required',

        ]);

// invoice data save
        $iv = new Invoice();
        $iv->invoice_code = $request->input('referenceNo');
        $iv->invoice_date = $request->input('datepicker');
        $iv->location = $request->input('location');
        $iv->biller = $request->input('biller');
        $iv->customer = $request->input('customer');
        $iv->tax_amount = self::numberFormatRemove(number_format($request->input('grand_tax'), 2));
        $iv->discount = self::numberFormatRemove(number_format($request->input('grand_discount'), 2));
        $iv->discount_val_or_per = ($request->input('wholeDiscount') == '') ? 0 : self::numberFormatRemove(number_format($request->input('wholeDiscount', 2)));
        $iv->invoice_grand_total = self::numberFormatRemove(number_format($request->input('grand_total'), 2));
        $iv->tax_per = $request->input('grand_tax_id');
        $iv->sales_status = $request->input('saleStatus');
        $iv->status = \Config::get('constants.status.Active');
        $iv->payment_status = $request->input('paymetStatus');
        $iv->sale_note = $request->input('saleNote');
        $iv->staff_note = $request->input('staffNote');

        $iv->save();

        // stock reduce
        $stockAdd = new Stock();
        $stockAdd->po_reference_code = 'INVOICE-S';
        $stockAdd->receive_code = $request->input('referenceNo') . '-S';
        $stockAdd->location = $request->input('location');
        $stockAdd->receive_date = $request->input('datepicker');
        $stockAdd->remarks = '';
        $stockAdd->save();

        $items = $request->input('item');
        $quantity = $request->input('quantity');
        $costPrice = $request->input('costPrice');
        $p_tax = $request->input('p_tax');
        $unit = $request->input('unit');
        $subtot = $request->input('subtot');
        $discount = $request->input('discount');
        $tax_id = $request->input('tax_id');

        foreach ($items as $id => $item) {

            if ($subtot[$id] > 0) {
                $invoItems = new InvoiceDetails();

                $invoItems->item_id = $item;
                $invoItems->serial_number = '';
                $invoItems->selling_price = self::numberFormatRemove(number_format($costPrice[$id], 2));
                $invoItems->qty = $quantity[$id];
                $invoItems->tax_val = $p_tax[$id];
                $invoItems->discount = self::numberFormatRemove(number_format($discount[$id], 2));
                $invoItems->tax_per = $tax_id[$id];
                $invoItems->sub_total = self::numberFormatRemove(number_format($subtot[$id], 2));

                $iv->invoiceItems()->save($invoItems);

                // stick items reduce
                $itemSubs = new StockItems();
                $itemSubs->item_id = $item;
                $itemSubs->cost_price = self::numberFormatRemove(number_format($costPrice[$id], 2));
                $itemSubs->qty = $quantity[$id];
                $itemSubs->tax_per = $tax_id[$id];
                $itemSubs->method = 'S';
                $stockAdd->stockItems()->save($itemSubs);
            }

        }

        if (!$iv) {
            $request->session()->flash('message', 'Error in the database while creating the Invoice');
            $request->session()->flash('message-type', 'error');
        } else {
            $request->session()->flash('message', 'Successfully created ' . "[ Ref NO:" . $request->input('referenceNo') . " ]");
            $request->session()->flash('message-type', 'success');
        }
        echo json_encode(array('success' => true));
    }

    public function invoList()
    {
        if (!Permissions::getRolePermissions('viewSale')) {
            abort(403, 'Unauthorized action.');
        }
        return view('vendor.adminlte.sales.index');
    }

    public function editView($id)
    {
        if (!Permissions::getRolePermissions('updateSale')) {
            abort(403, 'Unauthorized action.');
        }
        $locations = Locations::where('status', \Config::get('constants.status.Active'))->get();
        $billers = Biller::where('status', \Config::get('constants.status.Active'))->get();
        $tax = Tax::where('status', \Config::get('constants.status.Active'))->get();
        $customers = Customer::where('status', \Config::get('constants.status.Active'))->get();

        $invoData = Invoice::find($id);

        return view('vendor.adminlte.sales.edit', ['locations' => $locations, 'billers' => $billers, 'tax' => $tax, 'sales' => $invoData, 'customers' => $customers]);
    }

    public function fetchSalesData()
    {
        $result = array('data' => array());

//        $data = Invoice::where('status', \Config::get('constants.status.Active'))->orderBy('sales', 'asc')->get();
//        $data = Invoice::orderBy('due_date', 'desc')->get();
        $data = Invoice::get();

        foreach ($data as $key => $value) {
            // button
            $buttons = '';
            $editbutton = '';
            $deleteButton = '';

            if (Permissions::getRolePermissions('updateSale')) {
                $editbutton .= "<li><a href=\"/sales/edit/" . $value->id . "\">Edit Sale</a></li>";
            }

            if (Permissions::getRolePermissions('deleteSale')) {
                $deleteButton .= "<li><a style='cursor: pointer' onclick=\"deleteSale(" . $value->id . ")\">Delete</a></li>";
            }

            //incremental code
            $lastStockRefCode = Stock::all()->last();
            $data = (isset($lastStockRefCode->receive_code)) ? str_replace("TR-", "PR-", str_replace("-S", "", str_replace("-A", "", $lastStockRefCode->receive_code))) : 'PR-000000';
            $code = preg_replace_callback("|(\d+)|", "self::replace", $data);


            $buttons = "<div class=\"btn-group\">
                  <button type=\"button\" class=\"btn btn-default btn-flat\">Action</button>
                  <button type=\"button\" class=\"btn btn-default btn-flat dropdown-toggle\" data-toggle=\"dropdown\">
                    <span class=\"caret\"></span>
                    <span class=\"sr-only\">Toggle Dropdown</span>
                  </button>
                  <ul class=\"dropdown-menu\" role=\"menu\">
                      " . $editbutton . "
                    <li><a href=\"/sales/view/" . $value->id . "\">Sale details view</a></li>
                    <li><a href=\"/sales/print/" . $value->id . "\">Download as PDF</a></li>
                    <li><a href=\"/send/sale/email/" . $value->id . "\">Email Sale</a></li>
                    <li class=\"divider\"></li>
                     " . $deleteButton . "
                  </ul>
                </div><input type='hidden' id='recNo_" . $value->id . "' value='" . $code . "'>";

            switch ($value->sales_status):
                case 1:
                    $SaleStatus = '<span class="label label-warning">pending</span>';
                    break;
                case 2:
                    $SaleStatus = '<span class="label label-success">Completed</span>';
                    break;
                default:
                    $SaleStatus = '<span class="label label-danger">Nothing</span>';
                    break;
            endswitch;

            switch ($value->payment_status):
                case 1:
                    $payStatus = '<span class="label label-warning">pending</span>';
                    break;
                case 2:
                    $payStatus = '<span class="label label-success">Due</span>';
                    break;
                case 3:
                    $payStatus = '<span class="label label-success">Partial</span>';
                    break;
                case 4:
                    $payStatus = '<span class="label label-success">Paid</span>';
                    break;
                default:
                    $payStatus = '<span class="label label-danger">Nothing</span>';
                    break;
            endswitch;

            $result['data'][$key] = array(
                $value->invoice_date,
                $value->invoice_code,
                $value->billers->name,
                $value->customers->name,
                $SaleStatus,
                $value->invoice_grand_total,
                100,
                100,
                $payStatus,
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }

    public function editInvoData(Request $request, $id)
    {
//        print_r($request->input());
//        return '1111';
        $validator = Validator::make($request->all(), [
            'datepicker' => 'required|date',
            'saleStatus' => ['required', Rule::notIn(['0'])],
            'location' => ['required', Rule::notIn(['0'])],
            'referenceNo' => 'required|unique:invoice,invoice_code,' . $id . '|max:100',
            'biller' => ['required', Rule::notIn(['0'])],
            'customer' => ['required', Rule::notIn(['0'])],
            'paymetStatus' => ['required', Rule::notIn(['0'])],
            'grand_tax_id' => 'required',
        ]);


        $validator->validate();

        $iv = Invoice::find($id);
        $olderrefNo = $iv->invoice_code;
        $iv->invoice_code = $request->input('referenceNo');
        $iv->invoice_date = $request->input('datepicker');
        $iv->location = $request->input('location');
        $iv->biller = $request->input('biller');
        $iv->customer = $request->input('customer');
        $iv->tax_amount = self::numberFormatRemove(number_format($request->input('grand_tax'), 2));
        $iv->discount = self::numberFormatRemove(number_format($request->input('grand_discount'), 2));
        $iv->discount_val_or_per = ($request->input('wholeDiscount') == '') ? 0 : self::numberFormatRemove(number_format($request->input('wholeDiscount'), 2));
        $iv->invoice_grand_total = $request->input('grand_total');
        $iv->tax_per = $request->input('grand_tax_id');
        $iv->sales_status = $request->input('saleStatus');
        $iv->status = \Config::get('constants.status.Active');
        $iv->payment_status = $request->input('paymetStatus');
        $iv->sale_note = $request->input('saleNote');
        $iv->staff_note = $request->input('staffNote');

        //  subtract from stock table
        $stockSubstct = Stock::updateOrCreate([                         /* FROM */
            'receive_code' => $olderrefNo . '-S'
        ], [
            'receive_code' => $request->input('referenceNo') . '-S',
            'receive_date' => $request->input('datepicker'),
            'remarks' => '',
            'location' => $request->input('location'),
        ]);

        $items = $request->input('item');
        $quantity = $request->input('quantity');
        $costPrice = $request->input('costPrice');
        $p_tax = $request->input('p_tax');
        $unit = $request->input('unit');
        $tax_id = $request->input('tax_id');
        $subtot = $request->input('subtot');
        $discount = $request->input('discount');


        $deletedItems = (isset($request->deletedItems)) ? $request->deletedItems : '';

        if (is_array($deletedItems) && isset($deletedItems[0]) && array_sum($deletedItems) > 0) {
            $invoItemDel = Invoice::where('id', '=', $iv->id)->firstOrFail();
            $invoItemDel->invoiceItems()->whereIn('item_id', $deletedItems)->delete();

            $StockItemDel = Stock::where('id', '=', $request->input('referenceNo') . '-S')->firstOrFail();
            $StockItemDel->stockItems()->whereIn('item_id', $deletedItems)->delete();
        }


        foreach ($items as $i => $item) {

            if ($subtot[$i] > 0) {
                InvoiceDetails::updateOrCreate(
                    [
                        'invoice_id' => $id,
                        'item_id' => $item
                    ],
                    [
                        'selling_price' => $costPrice[$i],
                        'qty' => $quantity[$i],
                        'tax_val' => self::numberFormatRemove($p_tax[$i]),
                        'tax_per' => $tax_id[$i],
                        'discount' => self::numberFormatRemove(number_format($discount[$i], 2)),
                        'sub_total' => self::numberFormatRemove(number_format($subtot[$i], 2)),
                    ]);

//                echo  $stockSubstct->id.'--';
//                echo $tax_id[$id].'--';
                StockItems::updateOrCreate(                             /* From */
                    [
                        'stock_id' => $stockSubstct->id,
                        'item_id' => $item
                    ],
                    [
                        'qty' => self::numberFormatRemove(number_format($quantity[$i], 2)),
                        'cost_price' => self::numberFormatRemove(number_format($costPrice[$i], 2)),
                        'tax_per' => $tax_id[$i],
                        'method' => 'S',
                    ]
                );

            }
        }


        if (!$iv->save()) {
            $request->session()->flash('message', 'Error in the database while updating the Invoice');
            $request->session()->flash('message-type', 'error');
        } else {
            $request->session()->flash('message', 'Successfully Updated ' . "[ Ref NO:" . $request->input('referenceNo') . " ]");
            $request->session()->flash('message-type', 'success');
        }
        echo json_encode(array('success' => true));
    }

    public function view($id)
    {
        if (!Permissions::getRolePermissions('viewSale')) {
            abort(403, 'Unauthorized action.');
        }
        $ivdata = Invoice::find($id);

        $location = $ivdata->locations;
        $biller = $ivdata->billers;
        $customer = $ivdata->customers;
        return view('vendor.adminlte.sales.view', ['location' => $location, 'customer' => $customer, 'biller' => $biller, 'sales' => $ivdata]);
    }

    public function print($id)
    {

        $ivdata = Invoice::find($id);

        $location = $ivdata->locations;
        $biller = $ivdata->billers;
        $customer = $ivdata->customers;
//return view('vendor.adminlte.sales.print', ['location' => $location, 'customer' => $customer, 'biller' => $biller, 'sales' => $ivdata]);
        $pdf = PDF::loadView('vendor.adminlte.sales.print', ['location' => $location, 'customer' => $customer, 'biller' => $biller, 'sales' => $ivdata]);
        return $pdf->download('print.pdf');


    }

    public function delete(Request $request, $id)
    {
        if (!Permissions::getRolePermissions('deleteSale')) {
            abort(403, 'Unauthorized action.');
        }
        $invData = Invoice::find($id);
        Stock::where('receive_code', '=', $invData->invoice_code . '-S')->firstOrFail()->delete();

        if (!$invData->delete()) {
            $request->session()->flash('message', 'Error in the database while deleting the Invoice');
            $request->session()->flash('message-type', 'error');
            return redirect()->back();
        } else {
            $request->session()->flash('message', 'Successfully Deleted');
            $request->session()->flash('message-type', 'success');
            return redirect()->route('sales.manage');
        }
    }

    public function mail($id, Request $request)
    {
        $ivdata = Invoice::find($id);

        $location = $ivdata->locations;
        $biller = $ivdata->billers;
        $customer = $ivdata->customers;

        $pdf = PDF::loadView('vendor.adminlte.sales.print', ['location' => $location, 'customer' => $customer, 'biller' => $biller, 'sales' => $ivdata]);

        $name = $customer->name;
        $email = $customer->email;
        $UserCompany = $customer->company;
        $path = 'vendor.adminlte.sales.mail';
        $type = 'Sale Details';
        $reference_number = $ivdata->invoice_code;

        $attach = $pdf->output();
        Mail::to($email)->send(new SendMailable($name, $reference_number, $type, $UserCompany, config('adminlte.title', 'AdminLTE 2'), $attach, $path));

        if (count(Mail::failures()) > 0) {
            $request->session()->flash('message', 'Email sent fail to ' . $name . ' (' . $email . ') ');
            $request->session()->flash('message-type', 'error');
            return redirect()->back();
        } else {
            $request->session()->flash('message', 'Email sent to ' . $name . ' (' . $email . ') ');
            $request->session()->flash('message-type', 'success');
            return redirect()->route('sales.manage');
        }
    }

}
