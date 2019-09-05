<?php

namespace App\Http\Controllers;

use App\Locations;
use App\Products;
use App\Stock;
use App\StockItems;
use App\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Object_;

class StockController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth' => 'verified']);
    }

    public function fetchProductsListWarehouseWise($id)
    {
//        echo $id;
//        $StockAddded = Stock::with('qtyAddedSum')->where('location', $id)->get()->toArray();
//        $StockSubs = Stock::with('qtySubsSum')->where('location', $id)->get()->toArray();

//        $list = array();
//        $key = 0;
//        foreach ($StockAddded as $stockItem) {
//            if (count($stockItem['qty_sum']) > 0) {
//
//                foreach ($stockItem['qty_sum'] as $item) {
//
//                    $itemId = $item['item_id'];
//                    $stockItemsSum = $item['sum'];
//                    $product = (object)Products::find($itemId)->toArray();
//
//                    $list[$key++] = array(
//                        'id' => $itemId,
//                        'name' => $product->name,
//                        'short_name' => $product->short_name,
//                        'item_code' => $product->item_code,
//                        'description' => $product->description,
//                        'img_url' => $product->img_url,
//                        'img_url' => $product->img_url,
//                        'selling_price' => $product->selling_price,
//                        'cost_price' => $product->cost_price,
//                        'weight' => $product->weight,
//                        'unit' => $product->unit,
//                        'reorder_level' => $product->reorder_level,
//                        'discount' => 0,
//                        'reorder_activation' => $product->reorder_activation,
//                        'tax' => (\Config::get('constants.taxActive.Active') == $product->tax_method) ? Tax::find($product->tax)->get()->toArray()[0]['value'] : 0,
//                        'sum' => $stockItemsSum,
//                    );
//                }
//            }
//        }

        /*   table inner joined queries   */
        //added stock count
        $qtyAddedSum = DB::table('stock')
            ->join('stock_items', 'stock.id', '=', 'stock_items.stock_id')
            ->select('stock.location', 'stock_items.item_id', DB::raw('sum(qty) as qtySum'))
            ->where('stock_items.method', '=', 'A')
            ->where('stock.location', '=', $id)
            ->WhereNull('stock.deleted_at')
            ->groupBy('item_id')
            ->get();


        $key = 0;
        $list = array();
        foreach ($qtyAddedSum as $AddedStockItem) {

            $qtySubstractedSum = DB::table('stock')
                ->join('stock_items', 'stock.id', '=', 'stock_items.stock_id')
                ->select('stock.location', 'stock_items.item_id', DB::raw('sum(qty) as qtySum'))
                ->where('stock_items.method', '=', 'S')
                ->where('stock.location', '=', $id)
                ->where('stock_items.item_id', '=', $AddedStockItem->item_id)
                ->WhereNull('stock.deleted_at')
                ->groupBy('item_id')
                ->get()->toArray();

            $substractQty = 0;
            if (count($qtySubstractedSum) > 0) {
                $substractQty = ($qtySubstractedSum[0]->qtySum);
            }

            $product = (object)Products::find($AddedStockItem->item_id)->toArray();

            if ($product->status == \Config::get('constants.status.Active')) {

                $list[$key++] = array(
                    'id' => $AddedStockItem->item_id,
                    'name' => $product->name,
                    'short_name' => $product->short_name,
                    'item_code' => $product->item_code,
                    'description' => $product->description,
                    'img_url' => $product->img_url,
                    'img_url' => $product->img_url,
                    'selling_price' => $product->selling_price,
                    'cost_price' => $product->cost_price,
                    'weight' => $product->weight,
                    'unit' => $product->unit,
                    'reorder_level' => $product->reorder_level,
                    'discount' => 0,
                    'reorder_activation' => $product->reorder_activation,
                    'tax' => (\Config::get('constants.taxActive.Active') == $product->tax_method && $product->tax != 0) ? Tax::find($product->tax)->get()->toArray()[0]['value'] : 0,
                    'sum' => $AddedStockItem->qtySum - $substractQty,
                );


            }
        }


        echo json_encode($list);
    }

    public function fetchProductsOneWarehouseWiseItem(Request $request)
    {
        $locationId = $request->input('wh');
        $itemId = $request->input('idItem');


        /*   table inner joined queries   */
        //added stock count
        $qtyAddedSum = DB::table('stock')
            ->join('stock_items', 'stock.id', '=', 'stock_items.stock_id')
            ->select('stock.location', 'stock_items.item_id', DB::raw('sum(qty) as qtySum'))
            ->where('stock_items.method', '=', 'A')
            ->where('stock.location', '=', $locationId)
            ->where('stock_items.item_id', '=', $itemId)
            ->WhereNull('stock.deleted_at')
            ->groupBy('item_id')
            ->get();


        $key = 0;
        $list = array();
        foreach ($qtyAddedSum as $AddedStockItem) {

            $qtySubstractedSum = DB::table('stock')
                ->join('stock_items', 'stock.id', '=', 'stock_items.stock_id')
                ->select('stock.location', 'stock_items.item_id', DB::raw('sum(qty) as qtySum'))
                ->where('stock_items.method', '=', 'S')
                ->where('stock.location', '=', $locationId)
                ->where('stock_items.item_id', '=', $itemId)
                ->WhereNull('stock.deleted_at')
                ->groupBy('item_id')
                ->get()->toArray();

            $substractQty = 0;
            if (count($qtySubstractedSum) > 0) {
                $substractQty = ($qtySubstractedSum[0]->qtySum);
            }

            $product = (object)Products::find($AddedStockItem->item_id)->toArray();

            if ($product->status == \Config::get('constants.status.Active')) {

                $list[$key++] = array(
                    'id' => $AddedStockItem->item_id,
                    'name' => $product->name,
                    'short_name' => $product->short_name,
                    'item_code' => $product->item_code,
                    'description' => $product->description,
                    'img_url' => $product->img_url,
                    'selling_price' => $product->selling_price,
                    'cost_price' => $product->cost_price,
                    'weight' => $product->weight,
                    'unit' => $product->unit,
                    'reorder_level' => $product->reorder_level,
                    'discount' => 0,
                    'reorder_activation' => $product->reorder_activation,
                    'tax' => (\Config::get('constants.taxActive.Active') == $product->tax_method && $product->tax != 0) ? Tax::find($product->tax)->get()->toArray()[0]['value'] : 0,
                    'sum' => $AddedStockItem->qtySum - $substractQty,
                );


            }
        }

        if (isset($request['requirement']) && $request['requirement'] == 'array') {
            return $list;
        } else {
            echo json_encode($list);
        }
    }

    public function itemQtySumNoteDeletedWareHouses($id)
    {


        $qtyAddedSum = DB::table('stock')
            ->select('stock.location', 'stock_items.item_id', DB::raw('sum(qty) as qtySum'))
            ->join('stock_items', 'stock.id', '=', 'stock_items.stock_id')
            ->join('locations', 'locations.id', '=', 'stock.location')
            ->where('stock_items.method', '=', 'A')
            ->where('stock_items.item_id', '=', $id)
            ->WhereNull('stock.deleted_at')
            ->WhereNull('locations.deleted_at')
            ->groupBy('item_id')
            ->get();

        $addedQty = 0;
        if (count($qtyAddedSum) > 0) {
            $addedQty = ($qtyAddedSum[0]->qtySum);
        }


        $qtySubstractedSum = DB::table('stock')
            ->select('stock.location', 'stock_items.item_id', DB::raw('sum(qty) as qtySum'))
            ->join('stock_items', 'stock.id', '=', 'stock_items.stock_id')
            ->join('locations', 'locations.id', '=', 'stock.location')
            ->where('stock_items.method', '=', 'S')
            ->where('stock_items.item_id', '=', $id)
            ->WhereNull('stock.deleted_at')
            ->WhereNull('locations.deleted_at')
            ->groupBy('item_id')
            ->get();

        $substractQty = 0;
        if (count($qtySubstractedSum) > 0) {
            $substractQty = ($qtySubstractedSum[0]->qtySum);
        }

        return ($addedQty >= $substractQty) ? number_format($addedQty - $substractQty, 0) : 'error';


    }
}
