<?php

namespace App\Http\Controllers;

use App\Biller;
use App\Customer;
use App\Invoice;
use App\Locations;
use App\PoDetails;
use App\Stock;
use App\StockItems;
use App\StockReturn;
use App\StockReturnItems;
use App\Supplier;
use App\Tax;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StockReturnController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth' => 'verified']);
    }

    public function index()
    {
        if (!Permissions::getRolePermissions('createSupplier')) {
            abort(403, 'Unauthorized action.');
        }
        $locations = Locations::where('status', \Config::get('constants.status.Active'))->get();
        $tax = Tax::where('status', \Config::get('constants.status.Active'))->get();
        $customers = Customer::where('status', \Config::get('constants.status.Active'))->get();
        $billers = Biller::where('status', \Config::get('constants.status.Active'))->get();
        $lastRefCode = StockReturn::where('return_reference_code', 'like', '%RETURNS%')->withTrashed()->get()->last();
        $data = (isset($lastRefCode->return_reference_code)) ? $lastRefCode->return_reference_code : 'RETURNS-' . '000000';

        $code = preg_replace_callback("|(\d+)|", "self::replace", $data);
        return view('vendor.adminlte.returns.create', ['locations' => $locations, 'tax' => $tax, 'lastRefCode' => $code, 'billers' => $billers, 'customers' => $customers]);
    }

    public function create(Request $request)
    {
        if (!Permissions::getRolePermissions('createSupplier')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'datepicker' => 'required|date',
            'referenceNo' => 'required|unique:stock_return,return_reference_code|max:100',
            'biller' => ['required', Rule::notIn(['0'])],
            'customer' => ['required', Rule::notIn(['0'])],
            'location' => ['required', Rule::notIn(['0'])],
        ]);


        $refCode = (substr($request->input('referenceNo'), 0, 7) !== 'RETURNS') ? "RETURNS-" . $request->input('referenceNo') : $request->input('referenceNo');

        $sr = new StockReturn();
        $sr->return_reference_code = $refCode;
        $sr->date = $request->input('datepicker');
        $sr->location = $request->input('location');
        $sr->biller = $request->input('biller');
        $sr->customer = $request->input('customer');
        $sr->tax_amount = self::numberFormatRemove(number_format($request->input('grand_tax'), 2));
        $sr->discount = self::numberFormatRemove(number_format($request->input('grand_discount'), 2));
        $sr->discount_val_or_per = ($request->input('wholeDiscount') == '') ? 0 : self::numberFormatRemove(number_format($request->input('wholeDiscount', 2)));
        $sr->grand_total = self::numberFormatRemove(number_format($request->input('grand_total'), 2));
        $sr->tax_per = $request->input('grand_tax_id');
        $sr->status = \Config::get('constants.status.Active');
        $sr->return_note = $request->input('returnNote');
        $sr->staff_note = $request->input('staffNote');

        $sr->save();

        // stock reduce
        $stockAdd = new Stock();
        $stockAdd->po_reference_code = 'RETURNS-A';
        $stockAdd->receive_code = $refCode . '-A';
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
                $retItems = new StockReturnItems();

                $retItems->item_id = $item;
                $retItems->selling_price = self::numberFormatRemove(number_format($costPrice[$id], 2));
                $retItems->qty = $quantity[$id];
                $retItems->tax_val = $p_tax[$id];
                $retItems->discount = self::numberFormatRemove(number_format($discount[$id], 2));
                $retItems->tax_per = $tax_id[$id];
                $retItems->sub_total = self::numberFormatRemove(number_format($subtot[$id], 2));

                $sr->returnItems()->save($retItems);

                // stick items reduce
                $itemSubs = new StockItems();
                $itemSubs->item_id = $item;
                $itemSubs->cost_price = self::numberFormatRemove(number_format($costPrice[$id], 2));
                $itemSubs->qty = $quantity[$id];
                $itemSubs->tax_per = $tax_id[$id];
                $itemSubs->method = 'A';
                $stockAdd->stockItems()->save($itemSubs);
            }

        }

        if (!$sr) {
            $request->session()->flash('message', 'Error in the database while creating the Return');
            $request->session()->flash('message-type', 'error');
        } else {
            $request->session()->flash('message', 'Successfully created ' . "[ Ref NO:" . $refCode . " ]");
            $request->session()->flash('message-type', 'success');
        }
        echo json_encode(array('success' => true));
    }

    public function retnList()
    {
        if (!Permissions::getRolePermissions('viewSupplier')) {
            abort(403, 'Unauthorized action.');
        }
        return view('vendor.adminlte.returns.index');
    }

    public function editView($id)
    {
        if (!Permissions::getRolePermissions('updateSupplier')) {
            abort(403, 'Unauthorized action.');
        }
        $locations = Locations::where('status', \Config::get('constants.status.Active'))->get();
        $billers = Biller::where('status', \Config::get('constants.status.Active'))->get();
        $tax = Tax::where('status', \Config::get('constants.status.Active'))->get();
        $customers = Customer::where('status', \Config::get('constants.status.Active'))->get();

        $srData = StockReturn::find($id);
        $stockData = Stock::with(['stockItems', 'stockItems.products'])->where('receive_code', $srData->return_reference_code . '-A')->get()->toArray();

        return view('vendor.adminlte.returns.edit', ['locations' => $locations, 'billers' => $billers, 'customers' => $customers, 'tax' => $tax, 'returns' => $srData]);
    }

    public function fetchReturnData()
    {
        $result = array('data' => array());

//        $data = StockReturn::where('status', \Config::get('constants.status.Active'))->orderBy('returns', 'asc')->get();
//        $data = StockReturn::orderBy('due_date', 'desc')->get();
        $data = StockReturn::get();

        foreach ($data as $key => $value) {
            // button
            $buttons = '';
            $editbutton = '';
            $deleteButton = '';

            if (Permissions::getRolePermissions('updateReturns')) {
                $editbutton .= "<li><a href=\"/returns/edit/" . $value->id . "\">Edit Return</a></li>";
            }

            if (Permissions::getRolePermissions('deleteReturns')) {
                $deleteButton .= "<li><a style='cursor: pointer' onclick=\"deleteRetrn(" . $value->id . ")\">Delete Return</a></li>";
            }

            $buttons = "<div class=\"btn-group\">
                  <button type=\"button\" class=\"btn btn-default btn-flat\">Action</button>
                  <button type=\"button\" class=\"btn btn-default btn-flat dropdown-toggle\" data-toggle=\"dropdown\">
                    <span class=\"caret\"></span>
                    <span class=\"sr-only\">Toggle Dropdown</span>
                  </button>
                  <ul class=\"dropdown-menu\" role=\"menu\">
                  " . $editbutton . "
                    <li><a href=\"/returns/view/" . $value->id . "\">View Return</a></li>
                    <li><a href=\"/returns/print/" . $value->id . "\">PDF Return</a></li>
                    <li class=\"divider\"></li>
                     " . $deleteButton . "
                  </ul>
                </div>";

            switch ($value->status):
                case 1:
                    $status = '<span class="label label-success">Completed</span>';
                    break;
                case 2:
                    $status = '<span class="label label-success">Pending</span>';
                    break;
                case 3:
                    $status = '<span class="label label-success">Send</span>';
                    break;
                case 4:
                    $status = '<span class="label label-warning">Canceled</span>';
                    break;
                default:
                    $status = '<span class="label label-warning">Nothing</span>';
                    break;
            endswitch;

            $result['data'][$key] = array(
                $value->date,
                $value->return_reference_code,
                $value->locations->name,
                $value->billers->name,
                $value->customers->name,
                number_format(($value->grand_total), 2),
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }

    public function editReturnData(Request $request, $id)
    {
        if (!Permissions::getRolePermissions('updateSupplier')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'datepicker' => 'required|date',
            'referenceNo' => 'required|unique:stock_return,return_reference_code,' . $id . '|max:100',
            'biller' => ['required', Rule::notIn(['0'])],
            'customer' => ['required', Rule::notIn(['0'])],
            'location' => ['required', Rule::notIn(['0'])],
        ]);

        $refCode = (substr($request->input('referenceNo'), 0, 7) !== 'RETURNS') ? "RETURNS-" . $request->input('referenceNo') : $request->input('referenceNo');

        $sr = StockReturn::find($id);
        $olederRefCode = $sr->return_reference_code;
        $sr->return_reference_code = $refCode;
        $sr->date = $request->input('datepicker');
        $sr->location = $request->input('location');
        $sr->biller = $request->input('biller');
        $sr->customer = $request->input('customer');
        $sr->tax_amount = self::numberFormatRemove(number_format($request->input('grand_tax'), 2));
        $sr->discount = self::numberFormatRemove(number_format($request->input('grand_discount'), 2));
        $sr->discount_val_or_per = ($request->input('wholeDiscount') == '') ? 0 : self::numberFormatRemove(number_format($request->input('wholeDiscount', 2)));
        $sr->grand_total = self::numberFormatRemove(number_format($request->input('grand_total'), 2));
        $sr->tax_per = $request->input('grand_tax_id');
        $sr->status = \Config::get('constants.status.Active');
        $sr->return_note = $request->input('returnNote');
        $sr->staff_note = $request->input('staffNote');


        // add stock to stock table
        $stockAdd = Stock::updateOrCreate([                             /* TO */
            'receive_code' => $olederRefCode . '-A'
        ], [
            'receive_code' => $refCode . '-A',
            'receive_date' => $request->input('datepicker'),
            'remarks' => $request->input('note'),
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
            $stockDelete_A = Stock::where('receive_code', 'like', '%' . $olederRefCode . '-A%')->firstOrFail();
            $stockDelete_A->stockItems()->whereIn('item_id', $deletedItems)->delete();

            $sr->returnItems()->whereIn('item_id', $deletedItems)->delete();
        }


//        StockItems::destroy($deletedItems);
        if (is_array($items)) {
            foreach ($items as $id => $item) {

                if ($subtot[$id] > 0) {

                    StockReturnItems::updateOrCreate(
                        [
                            'return_id' => $sr->id,
                            'item_id' => $item
                        ],
                        [
                            'qty' => self::numberFormatRemove($quantity[$id]),
                            'selling_price' => self::numberFormatRemove($costPrice[$id]),
                            'tax_per' => $tax_id[$id],
                            'tax_val' => $p_tax[$id],
                            'discount' => $discount[$id],
                            'sub_total' => $subtot[$id],
                        ]
                    );

                    StockItems::updateOrCreate(                             /* To */
                        [
                            'stock_id' => $stockAdd->id,
                            'item_id' => $item
                        ],
                        [
                            'qty' => self::numberFormatRemove($quantity[$id]),
                            'cost_price' => self::numberFormatRemove($costPrice[$id]),
                            'tax_per' => $tax_id[$id],
                            'method' => 'A',
                        ]
                    );
                }
            }
        }

        if (!$sr->save()) {
            $request->session()->flash('message', 'Error in the database while updating the Stock Return');
            $request->session()->flash('message-type', 'error');
        } else {
            $request->session()->flash('message', 'Successfully Updated ' . "[ Ref NO:" . $refCode . " ]");
            $request->session()->flash('message-type', 'success');
        }
        echo json_encode(array('success' => true));

    }

    public function delete(Request $request, $id)
    {
        if (!Permissions::getRolePermissions('deleteSupplier')) {
            abort(403, 'Unauthorized action.');
        }
        $srdata = StockReturn::find($id);
        Stock::where('receive_code', '=', $srdata->return_reference_code . '-A')->firstOrFail()->delete();

        if (!$srdata->delete()) {
            $request->session()->flash('message', 'Error in the database while deleting the StockReturn');
            $request->session()->flash('message-type', 'error');
            return redirect()->back();
        } else {
            $request->session()->flash('message', 'Successfully Deleted');
            $request->session()->flash('message-type', 'success');
            return redirect()->route('returns.manage');
        }
    }

    public function view($id)
    {
        if (!Permissions::getRolePermissions('viewSupplier')) {
            abort(403, 'Unauthorized action.');
        }
        $stdata = StockReturn::find($id);

        $location = $stdata->locations;
        $biller = $stdata->billers;
        $customer = $stdata->customers;
        return view('vendor.adminlte.returns.view', ['location' => $location, 'customer' => $customer, 'biller' => $biller, 'returns' => $stdata]);
    }

    public function print($id)
    {
        $trdata = StockReturn::find($id);

        $location = $trdata->locations;
        $biller = $trdata->billers;
        $customer = $trdata->customers;
//        return view('vendor.adminlte.returns.print', ['location' => $location, 'customer' => $customer, 'biller' => $biller, 'returns' => $trdata]);
        $pdf = PDF::loadView('vendor.adminlte.returns.print', ['location' => $location, 'customer' => $customer, 'biller' => $biller, 'returns' => $trdata]);
        return $pdf->download('return_' . $trdata->return_reference_code . '.pdf');
//        exit(0);

    }
}
