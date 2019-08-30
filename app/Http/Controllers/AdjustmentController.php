<?php

namespace App\Http\Controllers;

use App\Adjustment;
use App\Locations;
use App\Stock;
use App\StockItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdjustmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth' => 'verified']);
    }


    public function index()
    {
        $locations = Locations::where('status', \Config::get('constants.status.Active'))->get();
        $lastRefCode = Adjustment::where('reference_code', 'like', '%ADJUST%')->get()->last();
        $data = (isset($lastRefCode->reference_code)) ? $lastRefCode->reference_code : 'ADJUST-000000';

        $code = preg_replace_callback("|(\d+)|", "self::replace", $data);
        return view('vendor.adminlte.adjustment.create', ['locations' => $locations, 'lastRefCode' => $code]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'datepicker' => 'required|date',
            'location' => ['required', Rule::notIn(['0'])],
            'referenceNo' => 'required|unique:adjustment,reference_code|max:100',
        ]);

        $adjustment = new Adjustment();
        $adjustment->date = $request->input('datepicker');
        $adjustment->location = $request->input('location');
        $adjustment->reference_code = $request->input('referenceNo');
        $adjustment->note = $request->input('note');
        $adjustment->save();

        $items = $request->input('item');
        $quantity = $request->input('quantity');
        $types = $request->input('type');

        /* stock addition or subtraction check*/
        $addition = false;
        $subtraction = false;
        foreach ($types as $k => $type) {
            if ($type === 'A' && !$addition) {
                $addition = true;
            }
            if ($type === 'S' && !$subtraction) {
                $subtraction = true;
            }
        }
//        var_dump($addition);
//        var_dump($subtraction);
//        return 'ddd';

        if ($addition) {
            // stock reduce
            $stockAdd = new Stock();
            $stockAdd->po_reference_code = 'ADJUST-A';
            $stockAdd->receive_code = $request->input('referenceNo') . '-A';
            $stockAdd->location = $request->input('location');
            $stockAdd->receive_date = $request->input('datepicker');
            $stockAdd->remarks = '';
            $stockAdd->save();
        }
        if ($subtraction) {
            // stock reduce
            $stockSubs = new Stock();
            $stockSubs->po_reference_code = 'ADJUST-S';
            $stockSubs->receive_code = $request->input('referenceNo') . '-S';
            $stockSubs->location = $request->input('location');
            $stockSubs->receive_date = $request->input('datepicker');
            $stockSubs->remarks = '';
            $stockSubs->save();
        }


        foreach ($items as $id => $item) {

            if ($quantity[$id] > 0) {
                if ($addition && $types[$id] === 'A') {
                    // stock items add
                    $itemAdds = new StockItems();
                    $itemAdds->item_id = $item;
                    $itemAdds->qty = $quantity[$id];
                    $itemAdds->method = 'A';
                    $stockAdd->stockItems()->save($itemAdds);
                }

                if ($subtraction && $types[$id] === 'S') {
                    // stock items subs
                    $itemSubs = new StockItems();
                    $itemSubs->item_id = $item;
                    $itemSubs->qty = $quantity[$id];
                    $itemSubs->method = 'S';
                    $stockSubs->stockItems()->save($itemSubs);
                }
            }

        }


        if (!$adjustment) {
            $request->session()->flash('message', 'Error in the database while Product Quantity Adjust');
            $request->session()->flash('message-type', 'error');
        } else {
            $request->session()->flash('message', 'Product Quantity Successfully Adjust ' . "[ Ref NO:" . $request->input('referenceNo') . " ]");
            $request->session()->flash('message-type', 'success');
        }
        echo json_encode(array('success' => true));
    }

    public function adjustList()
    {
        return view('vendor.adminlte.adjustment.index');
    }

    public function editView($id)
    {
        $locations = Locations::where('status', \Config::get('constants.status.Active'))->get();


        $adData = Adjustment::find($id);
        $addedStock = Stock::where('receive_code', 'like', $adData->reference_code . '-A')->first();
        $subsStock = Stock::where('receive_code', 'like', $adData->reference_code . '-S')->first();

        return view('vendor.adminlte.adjustment.edit', ['locations' => $locations, 'adjustment' => $adData, 'added' => $addedStock, 'subs' => $subsStock]);
    }

    public function fetchAdjData()
    {
        $result = array('data' => array());

//        $data = Adjustment::where('status', \Config::get('constants.status.Active'))->orderBy('adjustment', 'asc')->get();
//        $data = Adjustment::orderBy('due_date', 'desc')->get();
        $data = Adjustment::get();

        foreach ($data as $key => $value) {
            // button
            $buttons = '';

//            if (Permissions::getRolePermissions('vi   ewPO')) {

            $buttons .= '<a  class="btn btn-default" href="/adjustment/edit/' . $value->id . '"  ><i class="fa fa-pencil"></i></a>';
//            }

//            if (Permissions::getRolePermissions('deletePO')) {
            $buttons .= ' <button type="button" class="btn btn-default" onclick="deleteAdjust(' . $value->id . ')" data-toggle="modal" data-target="#removePOModal"><i class="fa fa-trash"></i></button>';
            $buttons .= ' <a  class="btn btn-default"  href="/adjustment/view/' . $value->id . '" ><i class="glyphicon glyphicon-eye-open"></i></a>';
//            }


            $result['data'][$key] = array(
                $value->date,
                $value->reference_code,
                $value->locations->name,
                $value->creator->name,
                $value->note,
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }

    public function editAdjData(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'datepicker' => 'required|date',
            'location' => ['required', Rule::notIn(['0'])],
            'referenceNo' => 'required|unique:adjustment,reference_code,' . $id . '|max:100',
        ]);

        $validator->validate();

//        print_r($request->input());
//        return 'ccc';

        $adjustment = Adjustment::find($id);
        $oldRefCode = $adjustment->reference_code;

        $adjustment->date = $request->input('datepicker');
        $adjustment->location = $request->input('location');
        $adjustment->reference_code = $request->input('referenceNo');
        $adjustment->note = $request->input('note');

        $items = $request->input('item');
        $quantity = $request->input('quantity');
        $types = $request->input('type');


        /* stock addition or subtraction check*/
        $addition = false;
        $subtraction = false;
        foreach ($types as $k => $type) {
            if ($type === 'A' && !$addition) {
                $addition = true;
            }
            if ($type === 'S' && !$subtraction) {
                $subtraction = true;
            }
        }

        if ($addition) {
            // add stock to stock table
            $stockAdd = Stock::updateOrCreate([                             /* TO */
                'receive_code' => $oldRefCode . '-A'
            ], [
                'receive_code' => $request->input('referenceNo') . '-A',
                'receive_date' => $request->input('datepicker'),
                'location' => $request->input('location'),
            ]);
        }
//        print_r($request->input());
//        print_r($oldRefCode . '-A');
//        var_dump($addition);
//        return 'ccc';

        if ($subtraction) {
            // add stock to stock table
            $stockSubs = Stock::updateOrCreate([                             /* TO */
                'receive_code' => $oldRefCode . '-S'
            ], [
                'receive_code' => $request->input('referenceNo') . '-S',
                'receive_date' => $request->input('datepicker'),
                'location' => $request->input('location'),
            ]);
        }

        $deletedItems = (isset($request->deletedItems)) ? $request->deletedItems : '';
        if (is_array($deletedItems) && isset($deletedItems[0]) && array_sum($deletedItems) > 0) {
            $stockDelete_A = Stock::where('receive_code', 'like', '%' . $oldRefCode . '-A%')->firstOrFail();
            $stockDelete_A->stockItems()->whereIn('item_id', $deletedItems)->delete();

            $stockDelete_S = Stock::where('receive_code', 'like', '%' . $oldRefCode . '-S%')->firstOrFail();
            $stockDelete_S->stockItems()->whereIn('item_id', $deletedItems)->delete();
        }


        foreach ($items as $i => $item) {
//            print_r($tax_id);
//            echo $id . '==' . $item. '==' .$costPrice[$i]. '==' . $quantity[$i]. '=='.$p_tax[$i] . '=='. $tax_id[$i]. '=='.$discount[$i]. '=='.$subtot[$i]. '///';
            if ($quantity[$i] > 0) {
                if ($addition && $types[$i] === 'A') {
                    StockItems::updateOrCreate(                             /* To */
                        [
                            'stock_id' => $stockAdd->id,
                            'item_id' => $item
                        ],
                        [
                            'qty' => self::numberFormatRemove($quantity[$i]),
                            'method' => 'A'
                        ]
                    );
                }
                if ($subtraction && $types[$i] === 'S') {
                    StockItems::updateOrCreate(                             /* To */
                        [
                            'stock_id' => $stockSubs->id,
                            'item_id' => $item
                        ],
                        [
                            'qty' => self::numberFormatRemove($quantity[$i]),
                            'method' => 'S'
                        ]
                    );
                }
            }
        }


        if (!$adjustment->save()) {
            $request->session()->flash('message', 'Error in the database while updating the Adjustment');
            $request->session()->flash('message-type', 'error');
        } else {
            $request->session()->flash('message', 'Successfully Updated ' . "[ Ref NO:" . $request->input('referenceNo') . " ]");
            $request->session()->flash('message-type', 'success');
        }
        echo json_encode(array('success' => true));
    }

    public function view($id)
    {
        $locations = Locations::where('status', \Config::get('constants.status.Active'))->get();


        $adData = Adjustment::find($id);
        $addedStock = Stock::where('receive_code', 'like', $adData->reference_code . '-A')->first();
        $subsStock = Stock::where('receive_code', 'like', $adData->reference_code . '-S')->first();

        return view('vendor.adminlte.adjustment.view', ['locations' => $locations, 'adjustment' => $adData, 'added' => $addedStock, 'subs' => $subsStock]);
    }

    public function delete(Request $request, $id)
    {

        $adData = Adjustment::find($id);
        Stock::where('receive_code', 'like', $adData->reference_code . '%')->firstOrFail()->delete();

        if (!$adData->delete()) {
            $request->session()->flash('message', 'Error in the database while deleting the Adjustment');
            $request->session()->flash('message-type', 'error');
            return redirect()->back();
        } else {
            $request->session()->flash('message', 'Successfully Deleted');
            $request->session()->flash('message-type', 'success');
            return redirect()->route('adjustment.manage');
        }
    }


}
