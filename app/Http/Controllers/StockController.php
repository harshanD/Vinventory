<?php

namespace App\Http\Controllers;

use App\Products;
use App\Stock;
use App\StockItems;
use App\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Object_;

class StockController extends Controller
{
    public function fetchProductsListWarehouseWise($id)
    {

        $Stock = Stock::with('qtySum')->where('location', $id)->get()->toArray();

        $list = array();
        $key = 0;
        foreach ($Stock as $stockItem) {
            if (count($stockItem['qty_sum']) > 0) {
                $itemId = $stockItem['qty_sum'][0]['item_id'];
                $stockItemsSum = $stockItem['qty_sum'][0]['sum'];
                $product = (object)Products::find($itemId)->toArray();

                $list[$key++] = array(
                    'id' => $itemId,
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
                    'tax' => (\Config::get('constants.taxActive.Active') == $product->tax_method) ? Tax::find($product->tax)->get()->toArray()[0]['value'] : 0,
                    'sum' => $stockItemsSum,
                );
            }
        }

        /*   table inner joined queries   */

//        $qtySum = DB::table('stock')
//            ->join('stock_items', 'stock.id', '=', 'stock_items.stock_id')
//            ->select('stock.*', 'stock_items.*', DB::raw('sum(qty) as qtySum'))
//            ->groupBy('item_id')
//            ->get();
//
//        foreach ($qtySum as $stockItem) {
//
//                print_r($stockItem);
//
//        }


        echo json_encode($list);
    }
}
