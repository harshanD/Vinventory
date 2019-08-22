<?php

namespace App\Http\Controllers;

use App\Locations;
use App\Products;
use App\Supplier;
use App\Tax;
use App\PO;
use App\PoDetails;
use App\Stock;
use App\StockItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade as PDF;

class POController extends Controller
{


    public function index()
    {
        $locations = Locations::where('status', \Config::get('constants.status.Active'))->get();
        $supplier = Supplier::where('status', \Config::get('constants.status.Active'))->get();
        $tax = Tax::where('status', \Config::get('constants.status.Active'))->get();
        $lastRefCode = PO::all()->last();
        $data = (isset($lastRefCode->referenceCode)) ? $lastRefCode->referenceCode : 'PO-000000';

        $code = preg_replace_callback("|(\d+)|", "self::replace", $data);
        return view('vendor.adminlte.po.create', ['locations' => $locations, 'suppliers' => $supplier, 'tax' => $tax, 'lastRefCode' => $code]);
    }


    public function create(Request $request)
    {
        $request->validate([
            'datepicker' => 'required|date',
            'status' => ['required', Rule::notIn(['0'])],
            'location' => ['required', Rule::notIn(['0'])],
            'referenceNo' => 'required|unique:po_header,referenceCode|max:100',
            'supplier' => ['required', Rule::notIn(['0'])],
            'grand_tax_id' => 'required',

        ]);

        $po = new PO();
        $po->due_date = $request->input('datepicker');
        $po->location = $request->input('location');
        $po->referenceCode = $request->input('referenceNo');
        $po->supplier = $request->input('supplier');
        $po->tax = $request->input('grand_tax');
        $po->discount = $request->input('grand_discount');
        $po->discount_val_or_per = ($request->input('wholeDiscount') == '') ? 0 : $request->input('wholeDiscount');
        $po->remark = $request->input('note');
        $po->status = $request->input('status');
        $po->grand_total = $request->input('grand_total');
        $po->tax_percentage = $request->input('grand_tax_id');

        $po->save();

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
                $poItems = new PoDetails();

                $poItems->item_id = $item;
                $poItems->cost_price = $costPrice[$id];
                $poItems->qty = $quantity[$id];
                $poItems->tax_val = $p_tax[$id];
                $poItems->discount = $discount[$id];
                $poItems->tax_percentage = $tax_id[$id];
                $poItems->sub_total = $subtot[$id];

                $po->poDetails()->save($poItems);
            }

        }

        if (!$po) {
            $request->session()->flash('message', 'Error in the database while creating the PO');
            $request->session()->flash('message-type', 'error');
        } else {
            $request->session()->flash('message', 'Successfully created ' . "[ Ref NO:" . $request->input('referenceNo') . " ]");
            $request->session()->flash('message-type', 'success');
        }
        echo json_encode(array('success' => true));
    }

    public function poList()
    {
        return view('vendor.adminlte.po.index');
    }

    public function editView($id)
    {
        $locations = Locations::where('status', \Config::get('constants.status.Active'))->get();
        $supplier = Supplier::where('status', \Config::get('constants.status.Active'))->get();
        $tax = Tax::where('status', \Config::get('constants.status.Active'))->get();

        $podata = PO::find($id);

        return view('vendor.adminlte.po.edit', ['locations' => $locations, 'suppliers' => $supplier, 'tax' => $tax, 'po' => $podata]);
    }

    public function fetchPOData()
    {
        $result = array('data' => array());

//        $data = PO::where('status', \Config::get('constants.status.Active'))->orderBy('po', 'asc')->get();
//        $data = PO::orderBy('due_date', 'desc')->get();
        $data = PO::get();

        foreach ($data as $key => $value) {
            // button
            $buttons = '';

//            if (Permissions::getRolePermissions('vi   ewPO')) {
            $buttons .= '<button type="button" class="btn btn-default" onclick="editPO(' . $value->id . ')" data-toggle="modal" data-target="#editPOModal"><i class="fa fa-pencil"></i></button>';
//            }

//            if (Permissions::getRolePermissions('deletePO')) {
            $buttons .= ' <button type="button" class="btn btn-default" onclick="removePO(' . $value->id . ')" data-toggle="modal" data-target="#removePOModal"><i class="fa fa-trash"></i></button>';
//            }

            //incremental code
            $lastStockRefCode = Stock::all()->last();
            $data = (isset($lastStockRefCode->receive_code)) ? str_replace("TR-", "PR-", str_replace("-S", "", str_replace("-A", "", $lastStockRefCode->receive_code))) : 'PR-000000';
            $code = preg_replace_callback("|(\d+)|", "self::replace", $data);

            $statusOfReceiveAll = "";
            $statusOfpartiallyReceiveAll = "";
            $poQty = 0;
            $recQty = 0;
            foreach ($value->poDetails as $poitem) {
                $poQty += $poitem->qty;
                $recQty += $poitem->received_qty;
            }
            if ($recQty < $poQty) {
                $statusOfReceiveAll = "<li><a style='cursor: pointer' onclick=\"receiveAll(" . $value->id . ")\">Receive All</a></li>";
                $statusOfpartiallyReceiveAll = "<li><a style='cursor: pointer' onclick=\"partiallyReceive(" . $value->id . ")\">Partially Receive</a></li>";
            }


            $receivedIcon = '<i  class="fa fa-circle-thin"></i>';
            if ($poQty == $recQty) {
                $receivedIcon = '<i  class="fa fa-circle"></i>';
            } else if ($recQty != 0 && $recQty < $poQty) {
                $receivedIcon = '<i  class="fa fa-adjust"></i>';
            }

            $buttons = "<div class=\"btn-group\">
                  <button type=\"button\" class=\"btn btn-default btn-flat\">Action</button>
                  <button type=\"button\" class=\"btn btn-default btn-flat dropdown-toggle\" data-toggle=\"dropdown\">
                    <span class=\"caret\"></span>
                    <span class=\"sr-only\">Toggle Dropdown</span>
                  </button>
                  <ul class=\"dropdown-menu\" role=\"menu\">
                    <li><a href=\"/po/edit/" . $value->id . "\">Edit Purchase</a></li>
                    " . $statusOfReceiveAll . "
                    " . $statusOfpartiallyReceiveAll . "
                    <li><a href=\"/po/view/" . $value->id . "\">Purchase details view</a></li>
                    <li><a onclick=\"deletePo(" . $value->id . ")\">Delete</a></li>
                    <li class=\"divider\"></li>
                    <li><a href=\"#\">Separated link</a></li>
                  </ul>
                </div><input type='hidden' id='recNo_" . $value->id . "' value='" . $code . "'>";

            switch ($value->status):
                case 1:
                    $status = '<span class="label label-success">Received</span>';
                    break;
                case 2:
                    $status = '<span class="label label-success">Ordered</span>';
                    break;
                case 3:
                    $status = '<span class="label label-success">pending</span>';
                    break;
                case 4:
                    $status = '<span class="label label-warning">canceled</span>';
                    break;
                default:
                    $status = '<span class="label label-warning">Nothing</span>';
                    break;
            endswitch;

            $result['data'][$key] = array(
                $value->due_date,
                $value->referenceCode,
                $value->suppliers->name,
                $receivedIcon,
                $value->grand_total,
                100,
                100,
//                $value->paid,
//                $value->balance,
                $status,
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }

    public function fetchPODataById($id)
    {
        $data = (Object)PO::find($id)->toArray();

        echo json_encode(array('name' => $data->name, 'code' => $data->code, 'value' => $data->value,
            'type' => $data->type, 'status' => $data->status));

    }

    public function fetchPOItemsDataById(Request $request)
    {

        $data = PO::find($request->input('id'));

        $items = array();
        foreach ($data->poDetails as $key => $item) {
            $items[$key] = array(
                'name' => $item->product->name,
                'id' => $item->id,
                'item_id' => $item->item_id,
                'cost_price' => $item->cost_price,
                'qty' => $item->qty,
                'received_qty' => $item->received_qty,
                'tax_val' => $item->tax_val,
                'tax_percentage' => $item->tax_percentage,
                'discount' => $item->discount,
                'sub_total' => $item->sub_total,
            );
        }

        echo json_encode(array(
            'supplier' => $data->supplier,
            'location' => $data->location,
            'referenceCode' => $data->referenceCode,
            'discount' => $data->discount,
            'grand_total' => $data->grand_total,
            'items' => $items

        ));

    }

    public function editPOData(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'datepicker' => 'required|date',
            'status' => ['required', Rule::notIn(['0'])],
            'location' => ['required', Rule::notIn(['0'])],
            'referenceNo' => 'required|unique:po_header,referenceCode,' . $id . '|max:100',
            'supplier' => ['required', Rule::notIn(['0'])],
            'grand_tax_id' => 'required',
        ]);

        $validator->validate();

        $po = PO::find($id);
        $po->due_date = $request->input('datepicker');
        $po->location = $request->input('location');
        $po->referenceCode = $request->input('referenceNo');
        $po->supplier = $request->input('supplier');
        $po->tax = $request->input('grand_tax');
        $po->discount = $request->input('grand_discount');
        $po->discount_val_or_per = ($request->input('wholeDiscount') == '') ? 0 : $request->input('wholeDiscount');
        $po->remark = $request->input('note');
        $po->status = $request->input('status');
        $po->grand_total = $request->input('grand_total');
        $po->tax_percentage = $request->input('grand_tax_id');

        $items = $request->input('item');
        $quantity = $request->input('quantity');
        $costPrice = $request->input('costPrice');
        $p_tax = $request->input('p_tax');
        $unit = $request->input('unit');
        $tax_id = $request->input('tax_id');
        $subtot = $request->input('subtot');
        $discount = $request->input('discount');

        $deletedItems = $request->input('deletedItems');

        PoDetails::destroy($deletedItems);

        foreach ($items as $i => $item) {
//            print_r($tax_id);
//            echo $id . '==' . $item. '==' .$costPrice[$i]. '==' . $quantity[$i]. '=='.$p_tax[$i] . '=='. $tax_id[$i]. '=='.$discount[$i]. '=='.$subtot[$i]. '///';
            if ($subtot[$i] > 0) {

                $poItem = PoDetails::updateOrCreate(
                    [
                        'po_header' => $id,
                        'item_id' => $item
                    ],
                    [
                        'cost_price' => $costPrice[$i],
                        'qty' => $quantity[$i],
                        'tax_val' => $p_tax[$i],
                        'tax_percentage' => $tax_id[$i],
                        'discount' => $discount[$i],
                        'sub_total' => $subtot[$i],
                    ]);

            }
        }


        if (!$po->save()) {
            $request->session()->flash('message', 'Error in the database while updating the PO');
            $request->session()->flash('message-type', 'error');
        } else {
            $request->session()->flash('message', 'Successfully Updated ' . "[ Ref NO:" . $request->input('referenceNo') . " ]");
            $request->session()->flash('message-type', 'success');
        }
        echo json_encode(array('success' => true));
    }

    public function removePOData(Request $request)
    {

        $po = PO::find($request->input('id'));

        if (!$po->delete()) {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while removing the po information';
        } else {
            $response['success'] = true;
            $response['messages'] = 'Successfully Removed';
        }
        echo json_encode($response);
    }

    public function receiveAll(Request $request)
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


        $po = PO::find($request->input('poId'));
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
            $poitemOb->save();

//            products foe add as available stock qty
            $products = Products::find($poitemOb->item_id);
            $products->availability = $products->availability + $receQty;
            $products->save();

//            stock items for add reserving qty
            $stockItems = new StockItems();
            $stockItems->item_id = $poItem->id;
            $stockItems->qty = $receQty;
            $stockItems->cost_price = $poitemOb->cost_price;
            $stockItems->tax_per = $poitemOb->tax_percentage;
            $stock->stockItems()->save($stockItems);

        }


        if (!($stock)) {
            $request->session()->flash('message', 'Error in the database while updating the PO');
            $request->session()->flash('message-type', 'error');
        } else {
            $request->session()->flash('message', 'Successfully Received All' . "[ Ref NO:" . $stock->receive_code . " ]");
            $request->session()->flash('message-type', 'success');
        }
        return redirect()->route('po.manage');
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

        $po = PO::find($request->input('poId'));
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

            if ($par_qty[$key] > 0) {

                $poitemOb = PoDetails::find($poItem);
                $poitemOb->received_qty = $poitemOb->received_qty + $par_qty[$key];
                $poitemOb->save();
                //            products foe add as available stock qty
                $products = Products::find($poitemOb->item_id);
                $products->availability = $products->availability + $par_qty[$key];
                $products->save();

                $stockItems = new StockItems();
                $stockItems->item_id = $poitemOb->item_id;
                $stockItems->qty = $par_qty[$key];
                $stockItems->cost_price = $poitemOb->cost_price;
                $stockItems->tax_per = $poitemOb->tax_percentage;
                $stock->stockItems()->save($stockItems);
            }
        }

        if (!($stock)) {
            $request->session()->flash('message', 'Error in the database while updating the PO');
            $request->session()->flash('message-type', 'error');
        } else {
            $request->session()->flash('message', 'Successfully Partially Received ' . "[ Res NO:" . $stock->receive_code . " ]");
            $request->session()->flash('message-type', 'success');
        }

        echo json_encode(array('success' => true));
    }

    public function view($id)
    {

        $podata = PO::find($id);

        $locations = $podata->locations;
        $supplier = $podata->suppliers;

        return view('vendor.adminlte.po.view', ['locations' => $locations, 'suppliers' => $supplier, 'po' => $podata]);
    }

    public function delete(Request $request, $id)
    {

        $podata = PO::find($id);

        if (!$podata->delete()) {
            $request->session()->flash('message', 'Error in the database while deleting the PO');
            $request->session()->flash('message-type', 'error');
            return redirect()->back();
        } else {
            $request->session()->flash('message', 'Successfully Deleted');
            $request->session()->flash('message-type', 'success');
            return redirect()->route('po.manage');
        }
    }

    public function printPO($id)
    {
        $podata = PO::find($id);
        $locations = $podata->locations;
        $supplier = $podata->suppliers;
//        return view('vendor.adminlte.po.printPo', ['locations' => $locations, 'suppliers' => $supplier, 'po' => $podata]);


//        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView('vendor.adminlte.po.printPo', ['locations' => $locations, 'suppliers' => $supplier, 'po' => $podata]);
//        $pdf->render();
//        $pdf = PDF::loadView('vendor.adminlte.po.test');
//        $pdf->save(storage_path().'printPo.pdf');
//        return $pdf->stream('printPo.pdf');
        return $pdf->download('printPo.pdf');
//        exit(0);

    }
}
