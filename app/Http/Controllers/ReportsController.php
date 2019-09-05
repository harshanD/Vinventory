<?php

namespace App\Http\Controllers;

use App\Locations;
use App\Products;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Object_;

class ReportsController extends Controller
{
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
        $in =0;
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
}
