<?php

namespace App\Http\Controllers;

use App\Adjustment;
use App\Locations;
use App\PO;
use App\Products;
use App\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Object_;
use function PHPSTORM_META\elementType;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth' => 'verified']);
    }

    public function warehouseStock(Request $request)
    {

        $warehouse = !isset($request['id']) ? 'All Warehouses' : '';

        $stock = new  StockController();
        $data = (object)Products::where(['status' => \Config::get('constants.status.Active')])->get();

        $totalQty = 0;
        $stockValueByPrice = 0;
        $stockValueByCost = 0;
        foreach ($data as $key => $product) {

            if ($warehouse == '') {
                $request['wh'] = $request['id'];
                $request['idItem'] = $product->id;
                $request['requirement'] = 'array';

                $qtyArray = ($stock->fetchProductsOneWarehouseWiseItem($request));
                $qty = (count($qtyArray) > 0) ? $qtyArray[0]['sum'] : 0;
            } else {
                $qty = json_decode($stock->itemQtySumNoteDeletedWareHouses($product->id));
            }

            $stockValueByPrice += $qty * $product->selling_price;
            $stockValueByCost += $qty * $product->cost_price;
            $totalQty += $qty;
        }

        if (($warehouse == '')) {
            $wh = Locations::where('id', '=', $request['id'])->firstOrFail()->toArray();
        }

        return view('vendor.adminlte.reports.warehouseStock.index',
            [
                'data' =>
                    array(
                        'itemCount' => count($data),
                        'totalQty' => $totalQty,
                        'stockValueByPrice' => $stockValueByPrice,
                        'stockValueByCost' => $stockValueByCost,
                        'profitEstimate' => $stockValueByPrice - $stockValueByCost,
                    ),
                'warehouse' => ($warehouse == '') ? $wh['name'] : $warehouse,
                'warehouseList' => Locations::where('status', \Config::get('constants.status.Active'))->get()
            ]);
    }

    public function quantityAlerts(Request $request)
    {
        $warehouse = !isset($request['id']) ? 'All Warehouses' : '';

        $stock = new  StockController();
        $data = (object)Products::where(['status' => \Config::get('constants.status.Active')])->get();
        $list = array();
        $in = 0;
        foreach ($data as $key => $product) {
            if ($product->reorder_activation == \Config::get('constants.status.Active')) {
                if ($warehouse == '') {
                    $request['wh'] = $request['id'];
                    $request['idItem'] = $product->id;
                    $request['requirement'] = 'array';

                    $qtyArray = ($stock->fetchProductsOneWarehouseWiseItem($request));
                    $qty = (count($qtyArray) > 0) ? $qtyArray[0]['sum'] : 0;
                } else {
                    $qty = json_decode($stock->itemQtySumNoteDeletedWareHouses($product->id));
                }
                if ($product->reorder_level >= $qty) {
                    $list[$in++] = array(
                        'image' => '<a href="' . asset('storage/' . $product->img_url) . '" class="image-link"><img src="' . asset('storage/' . $product->img_url) . '" style="width:50px;height:50px"  alt="placeholder avatar"></a>',
                        'code' => $product->item_code,
                        'name' => $product->name,
                        'qty' => $qty,
                        'alertQuantity' => $product->reorder_level,
                    );
                }
            }
        }
        if (($warehouse == '')) {
            $wh = Locations::where('id', '=', $request['id'])->firstOrFail()->toArray();
        }
        return view('vendor.adminlte.reports.quantityAlerts.index', ['data' => $list, 'warehouse' => ($warehouse == '') ? $wh['name'] : $warehouse, 'warehouseList' => Locations::where('status', \Config::get('constants.status.Active'))->get()]);
    }

    public function productsView(Request $request)
    {

        return view('vendor.adminlte.reports.productsReport.index');

    }

    public function fetchProductsData(Request $request)
    {
//        print_r($request->input());
//        return 'mm';


        $products = Products::where('status', \Config::get('constants.status.Active'))->get();


        $list = array();
        foreach ($products as $key => $product) {
            $dates = array();

            if ($request['from'] != '' && $request['to'] != '') {
                $dates = array('from' => $request['from'], 'to' => $request['to']);
            }

            $purchased = DB::table('po_header')
                ->select(DB::raw('ifnull(sum(po_details.qty*po_details.cost_price),0) as purchased'))
                ->join('po_details', 'po_details.po_header', '=', 'po_header.id')
                ->where('po_details.item_id', '=', $product->id)
                ->WhereNull('po_header.deleted_at')
                ->when(count($dates) > 0, function ($sold) use ($dates) {
                    return $sold->whereBetween('po_header.created_at', [$dates['from'] . ' 00:00:00', $dates['to'] . ' 00:00:00']);
                })
                ->groupBy('item_id')->get();

            $sold = DB::table('invoice')
                ->select(DB::raw('ifnull(sum(invoice_details.qty*invoice_details.selling_price),0) as sold'))
                ->join('invoice_details', 'invoice_details.invoice_id', '=', 'invoice.id')
                ->where('invoice_details.item_id', '=', $product->id)
                ->WhereNull('invoice.deleted_at')
                ->when(count($dates) > 0, function ($sold) use ($dates) {
                    return $sold->whereBetween('invoice.created_at', [$dates['from'] . ' 00:00:00', $dates['to'] . ' 00:00:00']);
                })
                ->groupBy('item_id')->get();

            $purchasedSum = 0;
            $soldSum = 0;

            if (count($purchased) > 0) {
                $purchasedSum = ($purchased[0]->purchased);
            }

            if (count($sold) > 0) {
                $soldSum = ($sold[0]->sold);
            }

            $list['data'][$key] = array(
                'item_code' => $product->item_code,
                'name' => $product->name,
                'purchased' => $purchasedSum,
                'sold' => $soldSum,
                'profitLess' => number_format($soldSum - $purchasedSum, 2),
            );

        }
        echo json_encode((isset($list['data']) ? $list : array('data' => array())));
    }

    public function adjustmentView()
    {
        return view('vendor.adminlte.reports.adjustmentReport.index');
    }

    public function adjustmentData(Request $request)
    {


        if ($request['from'] != '' && $request['to'] != '') {
            $dates = array('from' => $request['from'], 'to' => $request['to']);
            $adjustments = Adjustment::whereBetween('created_at', $dates)->get();
        } else {
            $adjustments = Adjustment::all();
        }

        $list = array();
        foreach ($adjustments as $key => $adj) {

            $list['data'][$key] = array(
                'date' => $adj->date,
                'reference_code' => $adj->reference_code,
                'location' => $adj->locations->name,
                'created_by' => $adj->creator->name,
                'note' => ($adj->note == '') ? '' : $adj->note,
            );

        }
        echo json_encode((isset($list['data']) ? $list : array('data' => array())));
    }

    public function fetchProductsData2DatatableExample(Request $request)
    {
        $users = Products::select([
            'item_code',
            'name',
            DB::raw('ifnull(sum((po_details.qty*po_details.cost_price)),0) AS purchased'),
            DB::raw('ifnull(sum((invoice_details.qty*invoice_details.selling_price)),0) AS sold'),
            DB::raw('ifnull(ifnull(sum((invoice_details.qty*invoice_details.selling_price)),0) -ifnull(sum((po_details.qty*po_details.cost_price)),0) ,0)AS profitLess'),
        ])->leftJoin('po_details', 'po_details.item_id', '=', 'products.id')
            ->leftJoin('po_header', 'po_header.id', '=', 'po_details.po_header')/**/
            ->leftJoin('invoice_details', 'invoice_details.item_id', '=', 'products.id')
            ->leftJoin('invoice', 'invoice.id', '=', 'invoice_details.invoice_id')/**/
            ->where('invoice.deleted_at', "=", null)
            ->where('po_header.deleted_at', '=', null)
//            ->where('products.status', '=', \Config::get('constants.status.Active'))
            ->groupBy('products.id');


//        // having count search
//        if ($post = $request->get('post')) {
//            $users->having('count', $request->get('operator'), $post);
//        }
//
//        // additional users.name search
//        if ($name = $request->get('name')) {
//            $users->where('users.name', 'like', "$name%");
//        }

        $datatables = app('datatables')->of($users);


        return $datatables->make(true);
    }
}
