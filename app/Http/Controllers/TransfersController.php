<?php

namespace App\Http\Controllers;

use App\Locations;
use App\Transfers;
use App\PoDetails;
use App\Stock;
use App\StockItems;
use App\Supplier;
use App\Tax;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TransfersController extends Controller
{
    public function index()
    {
        $locations = Locations::where('status', \Config::get('constants.status.Active'))->get();
        $supplier = Supplier::where('status', \Config::get('constants.status.Active'))->get();
        $tax = Tax::where('status', \Config::get('constants.status.Active'))->get();
        $lastRefCode = Transfers::all()->last();
        $data = (isset($lastRefCode->tr_reference_code)) ? $lastRefCode->tr_reference_code : 'TR-000000';

        $code = preg_replace_callback("|(\d+)|", "self::replace", $data);
        return view('vendor.adminlte.transfers.create', ['locations' => $locations, 'suppliers' => $supplier, 'tax' => $tax, 'lastRefCode' => $code]);
    }


    public function create(Request $request)
    {
        $request->validate([
            'datepicker' => 'required|date',
            'status' => ['required', Rule::notIn(['0'])],
            'referenceNo' => 'required|unique:transfers,tr_reference_code|max:100',
            'fromLocation' => ['required', Rule::notIn(['0'])],
            'toLocation' => ['required', Rule::notIn(['0'])],
        ]);

//        print_r($request->input());
//        return 'ss';
        $tr = new Transfers();
        $tr->tr_reference_code = $request->input('referenceNo');
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
        $stockAdd->receive_code = $request->input('referenceNo') . '-A';
        $stockAdd->location = $request->input('toLocation');
        $stockAdd->receive_date = $request->input('datepicker');
        $stockAdd->remarks = $request->input('note');
        $stockAdd->save();

        //  subtract from stock table
        $stockSubstct = new Stock();
        $stockSubstct->po_reference_code = 'TRANSFER-S';
        $stockSubstct->receive_code = $request->input('referenceNo') . '-S';
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
            $request->session()->flash('message', 'Successfully Transferred ' . "[ Ref NO:" . $request->input('referenceNo') . " ]");
            $request->session()->flash('message-type', 'success');
        }
        echo json_encode(array('success' => true));
    }

    public function transList()
    {
        return view('vendor.adminlte.transfers.index');
    }

    public function editView($id)
    {
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

//        $data = Transfers::where('status', \Config::get('constants.status.Active'))->orderBy('transfers', 'asc')->get();
//        $data = Transfers::orderBy('due_date', 'desc')->get();
        $data = Transfers::get();

        foreach ($data as $key => $value) {
            // button
            $buttons = '';

//            if (Permissions::getRolePermissions('vi   ewPO')) {
            $buttons .= '<button type="button" class="btn btn-default" onclick="editPO(' . $value->id . ')" data-toggle="modal" data-target="#editPOModal"><i class="fa fa-pencil"></i></button>';
//            }

//            if (Permissions::getRolePermissions('deletePO')) {
            $buttons .= ' <button type="button" class="btn btn-default" onclick="removePO(' . $value->id . ')" data-toggle="modal" data-target="#removePOModal"><i class="fa fa-trash"></i></button>';
//            }


            $buttons = "<div class=\"btn-group\">
                  <button type=\"button\" class=\"btn btn-default btn-flat\">Action</button>
                  <button type=\"button\" class=\"btn btn-default btn-flat dropdown-toggle\" data-toggle=\"dropdown\">
                    <span class=\"caret\"></span>
                    <span class=\"sr-only\">Toggle Dropdown</span>
                  </button>
                  <ul class=\"dropdown-menu\" role=\"menu\">
                    <li><a href=\"/transfer/edit/" . $value->id . "\">Edit Purchase</a></li>
                    <li><a href=\"/transfer/view/" . $value->id . "\">Transfer details</a></li>
                     <li><a href=\"/transfer/print/" . $value->id . "\">Download as PDF</a></li>
                    <li class=\"divider\"></li>
                     <li><a onclick=\"deletePo(" . $value->id . ")\">Delete Transfer</a></li>
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
                $value->tr_date,
                $value->tr_reference_code,
                (Locations::find($value->from_location)->toArray())['name'],
                (Locations::find($value->to_location)->toArray())['name'],
                number_format(($value->grand_total - $value->tot_tax), 2),
                number_format(($value->tot_tax), 2),
                number_format(($value->grand_total), 2),
                $status,
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }


    public function editTransferData(Request $request, $id)
    {

        $request->validate([
            'datepicker' => 'required|date',
            'status' => ['required', Rule::notIn(['0'])],
            'referenceNo' => 'required|unique:transfers,tr_reference_code,' . $id . '|max:100',
            'fromLocation' => ['required', Rule::notIn(['0'])],
            'toLocation' => ['required', Rule::notIn(['0'])],
        ]);


        $tr = Transfers::find($id);
        $olederRefCode = $tr->tr_reference_code;
        $tr->tr_reference_code = $request->input('referenceNo');
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
            'receive_code' => $request->input('referenceNo') . '-A',
            'receive_date' => $request->input('datepicker'),
            'remarks' => $request->input('note'),
            'location' => $request->input('toLocation'),
        ]);

        //  subtract from stock table
        $stockSubstct = Stock::updateOrCreate([                         /* FROM */
            'receive_code' => $olederRefCode . '-S'
        ], [
            'receive_code' => $request->input('referenceNo') . '-S',
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


        if (is_array($deletedItems) && isset($deletedItems[0])) {
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
            $request->session()->flash('message', 'Successfully Updated ' . "[ Ref NO:" . $request->input('referenceNo') . " ]");
            $request->session()->flash('message-type', 'success');
        }
        echo json_encode(array('success' => true));

    }

    public function removePOData(Request $request)
    {

        $po = Transfers::find($request->input('id'));

        if (!$po->delete()) {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while removing the transfers information';
        } else {
            $response['success'] = true;
            $response['messages'] = 'Successfully Removed';
        }
        echo json_encode($response);
    }

    public function receiveAll(Request $request)
    {

        $po = Transfers::find($request->input('poId'));
        $po->status = 1;
        $po->save();

        $stock = new Stock();
        $stock->po_reference_code = $po->referenceCode;
        $stock->receive_code = $request->input('recNo');
        $stock->location = $po->location;
        $stock->receive_date = $request->input('datepicker');
        $stock->remarks = $request->input('note');
        $stock->save();

        foreach ($po->poDetails as $poItem) {

            $poitemOb = PoDetails::find($poItem->id);
            $receQty = ($poItem->qty - $poitemOb->received_qty);
            $poitemOb->received_qty = $receQty;

            $stockItems = new StockItems();
            $stockItems->item_id = $poItem->id;
            $stockItems->qty = $receQty;
            $stock->stockItems()->save($stockItems);

        }


        if (!($poitemOb->save())) {
            $request->session()->flash('message', 'Error in the database while updating the Transfers');
            $request->session()->flash('message-type', 'error');
        } else {
            $request->session()->flash('message', 'Successfully Received All' . "[ Ref NO:" . $stock->receive_code . " ]");
            $request->session()->flash('message-type', 'success');
        }
        return redirect()->route('transfers.manage');
    }

    public function partiallyReceive(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'datepicker' => 'required|date',
            'recNo' => 'required|unique:stock,receive_code|max:100',
        ]);

        $niceNames = array(
            'recNo' => 'receive code',
            'datepicker' => 'receive date',
        );
        $validator->setAttributeNames($niceNames);

        $validator->validate();

        $po = Transfers::find($request->input('poId'));
        $po->status = 1;
        $po->save();

        $stock = new Stock();
        $stock->po_reference_code = $po->referenceCode;
        $stock->receive_code = $request->input('recNo');
        $stock->location = $po->location;
        $stock->receive_date = $request->input('datepicker');
        $stock->remarks = $request->input('note');
        $stock->save();

        $poItemsIds = $request->input('poItemsId');
        $par_qty = $request->input('par_qty');

        foreach ($poItemsIds as $key => $poItem) {

            $poitemOb = PoDetails::find($poItem);
            $poitemOb->received_qty = $poitemOb->received_qty + $par_qty[$key];

            $stockItems = new StockItems();
            $stockItems->item_id = $poitemOb->item_id;
            $stockItems->qty = $par_qty[$key];
            $stock->stockItems()->save($stockItems);

        }

        if (!($poitemOb->save())) {
            $request->session()->flash('message', 'Error in the database while updating the Transfers');
            $request->session()->flash('message-type', 'error');
        } else {
            $request->session()->flash('message', 'Successfully Partially Received ' . "[ Res NO:" . $stock->receive_code . " ]");
            $request->session()->flash('message-type', 'success');
        }

        echo json_encode(array('success' => true));
    }

    public function view($id)
    {

        $trdata = Transfers::find($id);
        $stock = Stock::where('receive_code', '=', $trdata->tr_reference_code . '-A')->firstOrFail();

        return view('vendor.adminlte.transfers.view', ['transfers' => $trdata, 'stock' => $stock]);
    }

    public function delete(Request $request, $id)
    {

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
        return $pdf->download('printPo.pdf');
//        exit(0);

    }
}
