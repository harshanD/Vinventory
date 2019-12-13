<?php

namespace App\Http\Controllers;

use App\Locations;
use App\Payments;
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
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;
use Yajra\DataTables\DataTables;

class POController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth' => 'verified']);
    }


    public function index()
    {
        if (!Permissions::getRolePermissions('createOrder')) {
            abort(403, 'Unauthorized action.');
        }
        $locations = Locations::where('status', \Config::get('constants.status.Active'))->get();
        $supplier = Supplier::where('status', \Config::get('constants.status.Active'))->get();
        $tax = Tax::where('status', \Config::get('constants.status.Active'))->get();
        $lastRefCode = PO::where('referenceCode', 'like', '%PO%')->withTrashed()->get()->last();
        $data = (isset($lastRefCode->referenceCode)) ? $lastRefCode->referenceCode : 'PO-000000';

        $code = preg_replace_callback("|(\d+)|", "self::replace", $data);
        return view('vendor.adminlte.po.create', ['locations' => $locations, 'suppliers' => $supplier, 'tax' => $tax, 'lastRefCode' => $code]);
    }


    public function create(Request $request)
    {
        if (!Permissions::getRolePermissions('createOrder')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'datepicker' => 'required|date',
            'status' => ['required', Rule::notIn(['0'])],
            'location' => ['required', Rule::notIn(['0'])],
            'referenceNo' => 'required|unique:po_header,referenceCode|max:97',
            'supplier' => ['required', Rule::notIn(['0'])],
            'grand_tax_id' => 'required',

        ]);

        $refCode = (substr($request->input('referenceNo'), 0, 2) !== 'PO') ? "PO-" . $request->input('referenceNo') : $request->input('referenceNo');

        $po = new PO();
        $po->due_date = $request->input('datepicker');
        $po->location = $request->input('location');
        $po->referenceCode = $refCode;
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
            $request->session()->flash('message', 'Successfully created ' . "[ Ref NO:" . $refCode . " ]");
            $request->session()->flash('message-type', 'success');
        }
        echo json_encode(array('success' => true));
    }

    public function poList()
    {
        if (!Permissions::getRolePermissions('viewOrder')) {
            abort(403, 'Unauthorized action.');
        }
        return view('vendor.adminlte.po.index');
    }

    public function editView($id)
    {
        if (!Permissions::getRolePermissions('updateOrder')) {
            abort(403, 'Unauthorized action.');
        }
        $locations = Locations::where('status', \Config::get('constants.status.Active'))->get();
        $supplier = Supplier::where('status', \Config::get('constants.status.Active'))->get();
        $tax = Tax::where('status', \Config::get('constants.status.Active'))->get();

        $podata = PO::find($id);

        return view('vendor.adminlte.po.edit', ['locations' => $locations, 'suppliers' => $supplier, 'tax' => $tax, 'po' => $podata]);
    }

    public function fetchPOData()
    {
        $query = PO::select(['id', 'supplier', 'referenceCode', 'due_date as date', 'payment_status', 'approve_status', 'grand_total', 'status']);
        return Datatables::of($query)
            ->addColumn('supplierName', function ($query) {
                return str_limit($query->suppliers->name, 20);
            })->addColumn('sale_status', function ($query) {
                switch ($query->status):
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
                return $SaleStatus;
            })->addColumn('grand_total', function ($query) {
                return number_format($query->grand_total, 2);
            })->addColumn('paid', function ($query) {
                $payments = new PaymentsController();
                $pending = $payments->refCodeByGetOutstanding($query->referenceCode);
                return number_format($pending, 2);
            })->addColumn('balance', function ($query) {
                $payments = new PaymentsController();
                $pending = $payments->refCodeByGetOutstanding($query->referenceCode);
                return number_format($query->grand_total - $pending, 2);
            })->addColumn('status', function ($query) {
                switch ($query->payment_status):
                    case \Config::get('constants.i_payment_status_name.Partial'):
                        $status = '<span class="label label-warning">Partial</span>';
                        break;
                    case \Config::get('constants.i_payment_status_name.Duo'):
                        $status = '<span class="label label-warning">Duo</span>';
                        break;
                    case \Config::get('constants.i_payment_status_name.Paid'):
                        $status = '<span class="label label-success">Paid</span>';
                        break;
                    case \Config::get('constants.i_payment_status_name.Pending'):
                        $status = '<span class="label label-warning">Pending</span>';
                        break;
                    case \Config::get('constants.i_payment_status_name.Over Paid'):
                        $status = '<span class="label label-danger">Over Paid</span>';
                        break;
                    default:
                        $status = '<span class="label label-warning">Nothing</span>';
                        break;
                endswitch;
                return $status;
            })->addColumn('received_icon', function ($query) {

                $poQty = 0;
                $recQty = 0;
                if (isset($query->poDetails)) {
                    foreach ($query->poDetails as $poitem) {
                        $poQty += $poitem->qty;
                        $recQty += $poitem->received_qty;
                    }
                }
                $receivedIcon = '<i  class="fa fa-circle-thin"></i>';
                if ($poQty == $recQty) {
                    $receivedIcon = '<i  class="fa fa-circle"></i>';
                } else if ($recQty != 0 && $recQty < $poQty) {
                    $receivedIcon = '<i  class="fa fa-adjust"></i>';
                }
                return $receivedIcon;
            })->addColumn('action', function ($query) {
                $editbutton = '';
                $deleteButton = '';

                if (Permissions::getRolePermissions('updateOrder')) {
                    $editbutton .= "<li><a href=\"/po/edit/" . $query->id . "\">Edit Purchase</a></li>";
                }

                if (Permissions::getRolePermissions('deleteOrder')) {
                    $deleteButton .= "<li><a style='cursor: pointer' onclick=\"deletePo(" . $query->id . ")\">Delete</a></li>";
                }

                //incremental code
                $lastStockRefCode = Stock::where('receive_code', 'like', '%R-%')->withTrashed()->get()->last();
//                $data = (isset($lastStockRefCode->receive_code)) ? str_replace("TR-", "PR-", str_replace("-S", "", str_replace("-A", "", $lastStockRefCode->receive_code))) : 'R-000000';
                $data = (isset($lastStockRefCode->receive_code)) ? $lastStockRefCode->receive_code : 'R-000000';
                $code = preg_replace_callback("|(\d+)|", "self::replace", $data);


                $statusOfReceiveAll = "";
                $statusOfpartiallyReceiveAll = "";
                $poQty = 0;
                $recQty = 0;

                if (isset($query->poDetails)) {
                    foreach ($query->poDetails as $poitem) {
                        $poQty += $poitem->qty;
                        $recQty += $poitem->received_qty;
                    }
                }
                if (Permissions::getRolePermissions('poStockReceive')) {
                    if ($recQty < $poQty) {
                        $statusOfReceiveAll = "<li><a style='cursor: pointer' onclick=\"receiveAll(" . $query->id . ")\">Receive All</a></li>";
                        $statusOfpartiallyReceiveAll = "<li><a style='cursor: pointer' onclick=\"partiallyReceive(" . $query->id . ")\">Partially Receive</a></li>";
                    }
                }

                /*payments check as full pad or duo*/
                $addPaymentLink = "";
                if ($query->payment_status == \Config::get('constants.i_payment_status_name.Partial') || $query->payment_status == \Config::get('constants.i_payment_status_name.Pending') || $query->payment_status == \Config::get('constants.i_payment_status_name.Duo')) {
                    $addPaymentLink = "<li><a style='cursor: pointer' onclick=\"addPayments(" . $query->id . ",'PO')\">Add Payments</a></li>";
                }

                $approvePO = "";
                if (Permissions::getRolePermissions('poApprove')) {
                    $approvePO = "<li class=\"divider\"></li><li><a>PO Approved </a></li>";
                    if ($query->approve_status == \Config::get('constants.po_approve.Not_approved')) {
                        $approvePO = "<li class=\"divider\"></li><li><a style='cursor: pointer' onclick=\"approvePO(" . $query->id . ")\">Approve PO</a></li>";
                    }
                }

                $sendMail = "";
                if (Permissions::getRolePermissions('poMail')) {
                    $sendMail = "<li><a href=\"/send/email/" . $query->id . "\">Send Mail</a></li>";
                }

                return $buttons = "<div class=\"btn-group\">
                  <button type=\"button\" class=\"btn btn-default btn-flat\">Action</button>
                  <button type=\"button\" class=\"btn btn-default btn-flat dropdown-toggle\" data-toggle=\"dropdown\">
                    <span class=\"caret\"></span>
                    <span class=\"sr-only\">Toggle Dropdown</span>
                  </button>
                  <ul class=\"dropdown-menu\" role=\"menu\">
                     " . $editbutton . "
                    " . $statusOfReceiveAll . "
                    " . $statusOfpartiallyReceiveAll . "
                    <li><a href=\"/po/view/" . $query->id . "\">Purchase details view</a></li>
                    <li><a style='cursor: pointer' onclick=\"showPayments(" . $query->id . ",'PO')\">View Payments</a></li>
                    " . $addPaymentLink . "
                    <li><a href=\"/po/printpo/" . $query->id . "\">Download as PDF</a></li>
                    " . $sendMail . "
              
                    " . $approvePO . "
                    <li class=\"divider\"></li>
                   " . $deleteButton . "
                  </ul>
                <input type='hidden' id='recNo_" . $query->id . "' value='" . $code . "'>
                </div>";

            })
//            ->editColumn('biller', '{!! str_limit($biller, 3) !!}')
            ->make(true);

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
        if (!Permissions::getRolePermissions('updateOrder')) {
            abort(403, 'Unauthorized action.');
        }
        $validator = Validator::make($request->all(), [
            'datepicker' => 'required|date',
            'status' => ['required', Rule::notIn(['0'])],
            'location' => ['required', Rule::notIn(['0'])],
            'referenceNo' => 'required|unique:po_header,referenceCode,' . $id . '|max:97',
            'supplier' => ['required', Rule::notIn(['0'])],
            'grand_tax_id' => 'required',
        ]);

        $validator->validate();

        $refCode = (substr($request->input('referenceNo'), 0, 2) !== 'PO') ? "PO-" . $request->input('referenceNo') : $request->input('referenceNo');

        $po = PO::find($id);
        $po->due_date = $request->input('datepicker');
        $po->location = $request->input('location');
        $po->referenceCode = $refCode;
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
            $request->session()->flash('message', 'Successfully Updated ' . "[ Ref NO:" . $refCode . " ]");
            $request->session()->flash('message-type', 'success');
        }
        echo json_encode(array('success' => true));
    }

    public function removePOData(Request $request)
    {
        if (!Permissions::getRolePermissions('deleteOrder')) {
            abort(403, 'Unauthorized action.');
        }
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
            'datepicker1' => 'receive date',
        );
        $validator->setAttributeNames($niceNames);

        $validator->validate();


        $po = PO::find($request->input('poId'));
        $po->status = 1;
        $po->save();

        //check po stock partially received before or not
//        $stock = Stock::where('po_reference_code', $request->input('recNo'));
//
//        if (empty($stock)) {
//            $stock->po_reference_code = $po->referenceCode;
//            $stock->receive_code = $request->input('recNo');
//            $stock->location = $po->location;
//            $stock->receive_date = $request->input('datepicker');
//            $stock->remarks = $request->input('note');
//        }else{
        $stock = new Stock();
        $stock->po_reference_code = $po->referenceCode;
        $stock->receive_code = $request->input('recNo');
        $stock->location = $po->location;
        $stock->receive_date = $request->input('datepicker');
        $stock->remarks = $request->input('note');
//        }
        $stock->save();

        foreach ($po->poDetails as $poItem) {

//            stock items for add reserving qty
//            $preStockSum = 0;
//            $preStockItems = StockItems::where(['po_reference_code' => $request->input('recNo'), 'item_id' => $poItem->id]);
//            if (!empty($preStockItems)) {
//                foreach ($preStockItems as $preStockItem) {
//                    $preStockSum += $preStockItem->qty;
//                }
//            }
            /*PO table updated as all items stock as received*/
            $poitemOb = PoDetails::find($poItem->id);
//            $receQty = (($poItem->qty - $preStockSum) - $poitemOb->received_qty);
            $receQty = ($poitemOb->qty - $poitemOb->received_qty);
            $poitemOb->received_qty = $poitemOb->qty;
            $poitemOb->save();

//            products foe add as available stock qty
            $products = Products::find($poitemOb->item_id);
            $products->availability = $products->availability + $receQty;
            $products->save();

            //            stock items for add reserving qty
            $stockItems = new StockItems();
            $stockItems->item_id = $poItem->item_id;
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
        echo json_encode(array('success' => true));
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
        if (!Permissions::getRolePermissions('viewOrder')) {
            abort(403, 'Unauthorized action.');
        }
        $podata = PO::find($id);

        $locations = $podata->locations;
        $supplier = $podata->suppliers;

        return view('vendor.adminlte.po.view', ['locations' => $locations, 'suppliers' => $supplier, 'po' => $podata]);
    }

    public function delete(Request $request, $id)
    {
        if (!Permissions::getRolePermissions('deleteOrder')) {
            abort(403, 'Unauthorized action.');
        }
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
//        return view('vendor.adminlte.po.printPo', ['locations' => $locations, 'suppliers' => $supplier, 'po' => $podata]);
        $pdf = PDF::loadView('vendor.adminlte.po.printPo', ['locations' => $locations, 'suppliers' => $supplier, 'po' => $podata]);
        return $pdf->download('printPo.pdf');
//        exit(0);
    }

    public function mailBody($id)
    {
        $podata = PO::find($id);
        $supplier = $podata->suppliers;
        $name = $supplier->name;
        $type = 'Purchase order';
        $reference_number = $podata->referenceCode;
        $company = config('adminlte.title', 'AdminLTE 2');
        return view('vendor.adminlte.po.mail', ['name' => $name, 'type' => $type, 'company' => $company, 'reference_number' => $reference_number]);
    }

    public function mail($id, Request $request)
    {
        $podata = PO::find($id);
        $locations = $podata->locations;
        $supplier = $podata->suppliers;
        $pdf = PDF::loadView('vendor.adminlte.po.printPo', ['locations' => $locations, 'suppliers' => $supplier, 'po' => $podata]);

        $name = $supplier->name;
        $email = $supplier->email;
        $UserCompany = $supplier->company;
        $path = 'vendor.adminlte.po.mail';
        $type = 'Purchase order';
        $reference_number = $podata->referenceCode;

        $attach = $pdf->output();
        Mail::to($email)->send(new SendMailable($name, $reference_number, $type, $UserCompany, config('adminlte.title', 'AdminLTE 2'), $attach, $path));

        if (count(Mail::failures()) > 0) {
            $request->session()->flash('message', 'Email sent fail to ' . $name . ' (' . $email . ') ');
            $request->session()->flash('message-type', 'error');
            return redirect()->back();
        } else {
            $request->session()->flash('message', 'Email sent to ' . $name . ' (' . $email . ') ');
            $request->session()->flash('message-type', 'success');
            return redirect()->route('po.manage');
        }
    }

    public function approvePO(Request $request)
    {
        $podata = PO::find($request['id']);
        $podata->approve_status = 1;

        if ($podata->save()) {
            $request->session()->flash('message', 'PO Approved (' . $podata->referenceCode . ')');
            $request->session()->flash('message-type', 'error');
        } else {
            $request->session()->flash('message', 'PO Approved fail');
            $request->session()->flash('message-type', 'success');
        }
        echo json_encode(array('success' => true));
    }
}
