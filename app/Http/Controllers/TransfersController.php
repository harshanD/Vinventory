<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Locations;
use App\Mail\SendMailable;
use App\Transfers;
use App\PoDetails;
use App\Stock;
use App\StockItems;
use App\Supplier;
use App\Tax;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class TransfersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth' => 'verified']);
    }

    public function index()
    {
        if (!Permissions::getRolePermissions('createTransfer')) {
            abort(403, 'Unauthorized action.');
        }
        $locations = Locations::where('status', \Config::get('constants.status.Active'))->get();
        $supplier = Supplier::where('status', \Config::get('constants.status.Active'))->get();
        $tax = Tax::where('status', \Config::get('constants.status.Active'))->get();
        $lastRefCode = Transfers::where('tr_reference_code', 'like', '%TR%')->withTrashed()->get()->last();
        $data = (isset($lastRefCode->tr_reference_code)) ? $lastRefCode->tr_reference_code : 'TR-000000';

        $code = preg_replace_callback("|(\d+)|", "self::replace", $data);
        return view('vendor.adminlte.transfers.create', ['locations' => $locations, 'suppliers' => $supplier, 'tax' => $tax, 'lastRefCode' => $code]);
    }


    public function create(Request $request)
    {
        if (!Permissions::getRolePermissions('createTransfer')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'datepicker' => 'required|date',
            'status' => ['required', Rule::notIn(['0'])],
            'referenceNo' => 'required|unique:transfers,tr_reference_code|max:100',
            'fromLocation' => ['required', Rule::notIn(['0'])],
            'toLocation' => ['required', Rule::notIn(['0'])],
        ]);

        $refCode = (substr($request->input('referenceNo'), 0, 2) !== 'TR') ? "TR-" . $request->input('referenceNo') : $request->input('referenceNo');

//        print_r($request->input());
//        return 'ss';
        $tr = new Transfers();
        $tr->tr_reference_code = $refCode;
        $tr->tr_date = $request->input('datepicker');
        $tr->from_location = $request->input('fromLocation');
        $tr->to_location = $request->input('toLocation');
        $tr->grand_total = self::numberFormatRemove($request->input('grand_total'));
        $tr->remarks = $request->input('note');
        $tr->status = $request->input('status');
        $tr->tot_tax = self::numberFormatRemove($request->input('grand_tax'));

        // add stock to stock table
        $stockAdd = new Stock();
        $stockAdd->po_reference_code = 'TRANSFER-A';
        $stockAdd->receive_code = $refCode . '-A';
        $stockAdd->location = $request->input('toLocation');
        $stockAdd->receive_date = $request->input('datepicker');
        $stockAdd->remarks = $request->input('note');
        $stockAdd->save();

        //  subtract from stock table
        $stockSubstct = new Stock();
        $stockSubstct->po_reference_code = 'TRANSFER-S';
        $stockSubstct->receive_code = $refCode . '-S';
        $stockSubstct->location = $request->input('fromLocation');
        $stockSubstct->receive_date = $request->input('datepicker');
        $stockSubstct->remarks = $request->input('note');
        $stockSubstct->save();

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
                $stockItemsAdd = new StockItems();
                $stockItemsAdd->item_id = $item;
                $stockItemsAdd->qty = self::numberFormatRemove($quantity[$id]);
                $stockItemsAdd->cost_price = self::numberFormatRemove($costPrice[$id]);
                $stockItemsAdd->tax_per = $tax_id[$id];
                $stockAdd->stockItems()->save($stockItemsAdd);

                $stockItemsSubstct = new StockItems();
                $stockItemsSubstct->item_id = $item;
                $stockItemsSubstct->qty = self::numberFormatRemove($quantity[$id]);
                $stockItemsSubstct->cost_price = self::numberFormatRemove($costPrice[$id]);
                $stockItemsSubstct->tax_per = $tax_id[$id];
                $stockItemsSubstct->method = "S";
                $stockSubstct->stockItems()->save($stockItemsSubstct);
            }

        }


        if (!($tr->save())) {
            $request->session()->flash('message', 'Error in the database while creating the Transfers');
            $request->session()->flash('message-type', 'error');
        } else {
            $request->session()->flash('message', 'Successfully Transferred ' . "[ Ref NO:" . $refCode . " ]");
            $request->session()->flash('message-type', 'success');
        }
        echo json_encode(array('success' => true));
    }

    public function transList()
    {
        if (!Permissions::getRolePermissions('viewTransfer')) {
            abort(403, 'Unauthorized action.');
        }
        return view('vendor.adminlte.transfers.index');
    }

    public function editView($id)
    {
        if (!Permissions::getRolePermissions('updateTransfer')) {
            abort(403, 'Unauthorized action.');
        }
        $locations = Locations::where('status', \Config::get('constants.status.Active'))->get();
        $supplier = Supplier::where('status', \Config::get('constants.status.Active'))->get();
        $tax = Tax::where('status', \Config::get('constants.status.Active'))->get();

        $trdata = Transfers::find($id);
        $stockData = Stock::with(['stockItems', 'stockItems.products'])->where('receive_code', $trdata->tr_reference_code . '-A')->get()->toArray();

        return view('vendor.adminlte.transfers.edit', ['locations' => $locations, 'suppliers' => $supplier, 'tax' => $tax, 'transfers' => $trdata, 'transfer_items' => ($stockData[0]['stock_items'])]);
    }

    public function fetchTransData()
    {
        $result = array('data' => array());

        $query = Transfers::select(['id', 'tr_reference_code', 'tr_date as date', 'to_location', 'from_location', 'tot_tax', 'grand_total', 'status']);

        return Datatables::of($query)
            ->addColumn('toLocation', function ($query) {
                return str_limit($query->toLocation->name, 20);
            })->addColumn('fromLocation', function ($query) {
                return str_limit($query->fromLocation->name, 20);
            })->addColumn('grand_total', function ($query) {
                return number_format($query->grand_total, 2);
            })->addColumn('total', function ($query) {
                return number_format($query->tot_tax + $query->grand_total, 2);
            })->addColumn('status', function ($query) {
                switch ($query->status):
                    case 1:
                        $status = '<span class="label label-success">Completed</span>';
                        break;
                    case 2:
                        $status = '<span class="label label-warning">Pending</span>';
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
                return $status;
            })->addColumn('action', function ($query) {
                $editbutton = '';
                $deleteButton = '';

                if (Permissions::getRolePermissions('updateTransfer')) {
                    $editbutton .= "<li><a href=\"/transfer/edit/" . $query->id . "\">Edit Transfer</a></li>";
                }

                if (Permissions::getRolePermissions('deleteTransfer')) {
                    $deleteButton .= "<li><a style='cursor: pointer' onclick=\"deletePo(" . $query->id . ")\">Delete Transfer</a></li>";
                }

                $sendMail = "";
                if (Permissions::getRolePermissions('transfersMail')) {
                    $sendMail = "<li><a href=\"/send/transfers/email/" . $query->id . "\">Email Transfer</a></li>";
                }

                return $buttons = "<div class=\"btn-group\">
                  <button type=\"button\" class=\"btn btn-default btn-flat\">Action</button>
                  <button type=\"button\" class=\"btn btn-default btn-flat dropdown-toggle\" data-toggle=\"dropdown\">
                    <span class=\"caret\"></span>
                    <span class=\"sr-only\">Toggle Dropdown</span>
                  </button>
                  <ul class=\"dropdown-menu\" role=\"menu\">
                    " . $editbutton . "
                    <li><a href=\"/transfer/view/" . $query->id . "\">Transfer details</a></li>
                     <li><a href=\"/transfer/print/" . $query->id . "\">Download as PDF</a></li>
                     " . $sendMail . "
                    <li class=\"divider\"></li>
                     " . $deleteButton . "
                  </ul>
                </div>";


            })
//            ->editColumn('biller', '{!! str_limit($biller, 3) !!}')
            ->make(true);
    }


    public function editTransferData(Request $request, $id)
    {
        if (!Permissions::getRolePermissions('updateTransfer')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'datepicker' => 'required|date',
            'status' => ['required', Rule::notIn(['0'])],
            'referenceNo' => 'required|unique:transfers,tr_reference_code,' . $id . '|max:100',
            'fromLocation' => ['required', Rule::notIn(['0'])],
            'toLocation' => ['required', Rule::notIn(['0'])],
        ]);

        $refCode = (substr($request->input('referenceNo'), 0, 2) !== 'TR') ? "TR-" . $request->input('referenceNo') : $request->input('referenceNo');

        $tr = Transfers::find($id);
        $olederRefCode = $tr->tr_reference_code;
        $tr->tr_reference_code = $refCode;
        $tr->tr_date = $request->input('datepicker');
        $tr->from_location = $request->input('fromLocation');
        $tr->to_location = $request->input('toLocation');
        $tr->grand_total = self::numberFormatRemove($request->input('grand_total'));
        $tr->remarks = $request->input('note');
        $tr->status = $request->input('status');
        $tr->tot_tax = self::numberFormatRemove($request->input('grand_tax'));


        // add stock to stock table
        $stockAdd = Stock::updateOrCreate([                             /* TO */
            'receive_code' => $olederRefCode . '-A'
        ], [
            'receive_code' => $refCode . '-A',
            'receive_date' => $request->input('datepicker'),
            'remarks' => $request->input('note'),
            'location' => $request->input('toLocation'),
        ]);

        //  subtract from stock table
        $stockSubstct = Stock::updateOrCreate([                         /* FROM */
            'receive_code' => $olederRefCode . '-S'
        ], [
            'receive_code' => $refCode . '-S',
            'receive_date' => $request->input('datepicker'),
            'remarks' => $request->input('note'),
            'location' => $request->input('fromLocation'),
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

            $stockDelete_S = Stock::where('receive_code', 'like', '%' . $olederRefCode . '-S%')->firstOrFail();
            $stockDelete_S->stockItems()->whereIn('item_id', $deletedItems)->delete();
        }


//        StockItems::destroy($deletedItems);
        if (is_array($items)) {
            foreach ($items as $id => $item) {

                if ($subtot[$id] > 0) {

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

                    StockItems::updateOrCreate(                             /* From */
                        [
                            'stock_id' => $stockSubstct->id,
                            'item_id' => $item
                        ],
                        [
                            'qty' => self::numberFormatRemove($quantity[$id]),
                            'cost_price' => self::numberFormatRemove($costPrice[$id]),
                            'tax_per' => $tax_id[$id],
                            'method' => 'S',
                        ]
                    );

                }
            }
        }

        if (!$tr->save()) {
            $request->session()->flash('message', 'Error in the database while updating the Transfers');
            $request->session()->flash('message-type', 'error');
        } else {
            $request->session()->flash('message', 'Successfully Updated ' . "[ Ref NO:" . $refCode . " ]");
            $request->session()->flash('message-type', 'success');
        }
        echo json_encode(array('success' => true));

    }

    public function view($id)
    {
        if (!Permissions::getRolePermissions('viewTransfer')) {
            abort(403, 'Unauthorized action.');
        }
        $trdata = Transfers::find($id);
        $stock = Stock::where('receive_code', '=', $trdata->tr_reference_code . '-A')->firstOrFail();

        return view('vendor.adminlte.transfers.view', ['transfers' => $trdata, 'stock' => $stock]);
    }

    public function delete(Request $request, $id)
    {
        if (!Permissions::getRolePermissions('deleteTransfer')) {
            abort(403, 'Unauthorized action.');
        }
        $trdata = Transfers::find($id);
        Stock::where('receive_code', '=', $trdata->tr_reference_code . '-A')->firstOrFail()->delete();
        Stock::where('receive_code', '=', $trdata->tr_reference_code . '-S')->firstOrFail()->delete();

        if (!$trdata->delete()) {
            $request->session()->flash('message', 'Error in the database while deleting the Transfers');
            $request->session()->flash('message-type', 'error');
            return redirect()->back();
        } else {
            $request->session()->flash('message', 'Successfully Deleted');
            $request->session()->flash('message-type', 'success');
            return redirect()->route('transfers.manage');
        }
    }

    public function print($id)
    {
        $trdata = Transfers::find($id);
        $stock = Stock::where('receive_code', '=', $trdata->tr_reference_code . '-A')->firstOrFail();

        $pdf = PDF::loadView('vendor.adminlte.transfers.print', ['transfers' => $trdata, 'stock' => $stock]);
//        $pdf->render();
//        $pdf = PDF::loadView('vendor.adminlte.transfers.test');
//        $pdf->save(storage_path().'printPo.pdf');
//        return $pdf->stream('printPo.pdf');
        return $pdf->download('transfer_' . $trdata->tr_reference_code . '.pdf');
//        exit(0);

    }

    public function mail($id, Request $request)
    {
        $trdata = Transfers::find($id);
        $stock = Stock::where('receive_code', '=', $trdata->tr_reference_code . '-A')->firstOrFail();

        $pdf = PDF::loadView('vendor.adminlte.transfers.print', ['transfers' => $trdata, 'stock' => $stock]);

        $name = '';
        $email = $trdata->toLocation->email;
        $UserCompany = '';
        $path = 'vendor.adminlte.transfers.mail';
        $type = 'Transfer Details';
        $reference_number = $trdata->tr_reference_code;

        $attach = $pdf->output();
        Mail::to($email)->send(new SendMailable($name, $reference_number, $type, $UserCompany, config('adminlte.title', 'AdminLTE 2'), $attach, $path));

        if (count(Mail::failures()) > 0) {
            $request->session()->flash('message', 'Email sent fail to ' . $name . ' (' . $email . ') ');
            $request->session()->flash('message-type', 'error');
            return redirect()->back();
        } else {
            $request->session()->flash('message', 'Email sent to ' . $name . ' (' . $email . ') ');
            $request->session()->flash('message-type', 'success');
            return redirect()->route('transfers.manage');
        }
    }
}
