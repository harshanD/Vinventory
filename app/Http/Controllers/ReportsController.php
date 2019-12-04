<?php

namespace App\Http\Controllers;

use App\Adjustment;
use App\Biller;
use App\Brands;
use App\Categories;
use App\Customer;
use App\Invoice;
use App\Locations;
use App\Payments;
use App\PO;
use App\Products;
use App\Role;
use App\Stock;
use App\Supplier;
use App\Transfers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
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
        if (!Permissions::getRolePermissions('warehouseStockReport')) {
            abort(403, 'Unauthorized action.');
        }
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
        if (!Permissions::getRolePermissions('productQualityAlerts')) {
            abort(403, 'Unauthorized action.');
        }
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
        if (!Permissions::getRolePermissions('productsReport')) {
            abort(403, 'Unauthorized action.');
        }
        return view('vendor.adminlte.reports.productsReport.index');
    }

    public function fetchProductsData(Request $request)
    {
        if (!Permissions::getRolePermissions('productsReport')) {
            abort(403, 'Unauthorized action.');
        }
        $products = Products::where('status', \Config::get('constants.status.Active'))->get();

        $stockController = new StockController();

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
            $qtySum = 0;
            if (count($dates) > 0) {
                $qtySum = $stockController->itemQtySumNoteDeletedWareHousesInDateRange($product->id, $dates['from'], $dates['to']);
            } else {
                $qtySum = $stockController->itemQtySumNoteDeletedWareHouses($product->id);
            }
            $qtyPrice = number_format($qtySum * $product->cost_price, 2);

            $list['data'][$key] = array(
                'item_code' => $product->item_code,
                'name' => $product->name,
                'purchased' => $purchasedSum,
                'sold' => $soldSum,
                'profitLess' => number_format($soldSum - $purchasedSum, 2),
                'stock_available' => '(' . $qtySum . ') ' . $qtyPrice,
            );

        }
        echo json_encode((isset($list['data']) ? $list : array('data' => array())));
    }

    public function categoryView(Request $request)
    {
        if (!Permissions::getRolePermissions('categoryReport')) {
            abort(403, 'Unauthorized action.');
        }
        return view('vendor.adminlte.reports.categoriesReport.index');
    }

    public function fetchCategoryData(Request $request)
    {
        if (!Permissions::getRolePermissions('categoryReport')) {
            abort(403, 'Unauthorized action.');
        }
        $stockController = new StockController();

        $list = array();

        $categories = Categories::where('status', \Config::get('constants.status.Active'))->get();
        foreach ($categories as $key => $category) {

            $purchasedSum = 0;
            $soldSum = 0;
            $qtySum = 0;
            $qtyPrice = 0;

            $products = Products::where('status', \Config::get('constants.status.Active'))->where('category', $category->id)->get();
            foreach ($products as $key1 => $product) {
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


                if (count($purchased) > 0) {
                    $purchasedSum += ($purchased[0]->purchased);
                }

                if (count($sold) > 0) {
                    $soldSum += ($sold[0]->sold);
                }

                if (count($dates) > 0) {
                    $qtySum = $stockController->itemQtySumNoteDeletedWareHousesInDateRange($product->id, $dates['from'], $dates['to']);
                } else {
                    $qtySum = $stockController->itemQtySumNoteDeletedWareHouses($product->id);
                }
                $qtyPrice += $qtySum * $product->cost_price;


            }
            $list['data'][$key] = array(
                'category_code' => $category->code,
                'name' => $category->category,
                'purchased' => $purchasedSum,
                'sold' => $soldSum,
                'profitLess' => number_format($soldSum - $purchasedSum, 2),
                'stock_available' => '(' . $qtySum . ') ' . number_format($qtyPrice, 2),
            );
        }
        echo json_encode((isset($list['data']) ? $list : array('data' => array())));
    }

    public function brandsView(Request $request)
    {
        if (!Permissions::getRolePermissions('brandsReport')) {
            abort(403, 'Unauthorized action.');
        }
        return view('vendor.adminlte.reports.brandsReport.index');
    }

    public function fetchBrandsData(Request $request)
    {
        if (!Permissions::getRolePermissions('brandsReport')) {
            abort(403, 'Unauthorized action.');
        }

        $stockController = new StockController();

        $list = array();

        $brands = Brands::where('status', \Config::get('constants.status.Active'))->get();
        foreach ($brands as $key => $brand) {

            $purchasedSum = 0;
            $soldSum = 0;
            $qtySum = 0;
            $qtyPrice = 0;

            $products = Products::where('status', \Config::get('constants.status.Active'))->where('category', $brand->id)->get();
            foreach ($products as $key1 => $product) {
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


                if (count($purchased) > 0) {
                    $purchasedSum += ($purchased[0]->purchased);
                }

                if (count($sold) > 0) {
                    $soldSum += ($sold[0]->sold);
                }

                if (count($dates) > 0) {
                    $qtySum = $stockController->itemQtySumNoteDeletedWareHousesInDateRange($product->id, $dates['from'], $dates['to']);
                } else {
                    $qtySum = $stockController->itemQtySumNoteDeletedWareHouses($product->id);
                }
                $qtyPrice += $qtySum * $product->cost_price;


            }
            $list['data'][$key] = array(
                'brand_code' => $brand->code,
                'name' => $brand->brand,
                'purchased' => $purchasedSum,
                'sold' => $soldSum,
                'profitLess' => number_format($soldSum - $purchasedSum, 2),
                'stock_available' => '(' . $qtySum . ') ' . number_format($qtyPrice, 2),
            );
        }
        echo json_encode((isset($list['data']) ? $list : array('data' => array())));
    }

    public function adjustmentView()
    {
        if (!Permissions::getRolePermissions('adjustmentsReport')) {
            abort(403, 'Unauthorized action.');
        }
        $adjustments = Adjustment::groupBy('created_by')->get();
        $locations = Locations::all();

        return view('vendor.adminlte.reports.adjustmentReport.index', ['adjustUsers' => $adjustments, 'warehouses' => $locations]);
    }

    public function adjustmentData(Request $request)
    {
        if (!Permissions::getRolePermissions('adjustmentsReport')) {
            abort(403, 'Unauthorized action.');
        }
        $dates = array('from' => $request['from'], 'to' => $request['to']);

        if (($request['from'] != '' && $request['to'] != '') && $request['warehouse'] == '0' && $request['createUser'] == '0') {
            $adjustments = Adjustment::whereBetween('created_at', $dates)->get();
        } elseif (($request['from'] != '' && $request['to'] != '') && $request['warehouse'] != '0' && $request['createUser'] == '0') {
            $adjustments = Adjustment::whereBetween('created_at', $dates)->where('location', $request['warehouse'])->get();
        } elseif (($request['from'] != '' && $request['to'] != '') && $request['warehouse'] != '0' && $request['createUser'] != '0') {
            $adjustments = Adjustment::whereBetween('created_at', $dates)->where('location', $request['warehouse'])->where('created_by', $request['createUser'])->get();
        } elseif (($request['from'] != '' && $request['to'] != '') && $request['warehouse'] == '0' && $request['createUser'] != '0') {
            $adjustments = Adjustment::whereBetween('created_at', $dates)->where('created_by', $request['createUser'])->get();
        } elseif (!($request['from'] != '' && $request['to'] != '') && $request['warehouse'] == '0' && $request['createUser'] != '0') {
            $adjustments = Adjustment::where('created_by', $request['createUser'])->get();
        } elseif (!($request['from'] != '' && $request['to'] != '') && $request['warehouse'] != '0' && $request['createUser'] == '0') {
            $adjustments = Adjustment::where('location', $request['warehouse'])->get();
        } elseif (!($request['from'] != '' && $request['to'] != '') && $request['warehouse'] != '0' && $request['createUser'] != '0') {
            $adjustments = Adjustment::where('created_by', $request['createUser'])->where('location', $request['warehouse'])->get();
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

    public function dailySalesIndex(Request $request)
    {
        if (!Permissions::getRolePermissions('dailySales')) {
            abort(403, 'Unauthorized action.');
        }
        $yearMonth = date('Y-m');
        $table = $this->drawTable(date('m'), date('Y'));

        return view('vendor.adminlte.reports.dailySalesReport.index', ['table' => $table, 'yearMonth' => $yearMonth]);
    }

    public function dailySalesForMonth(Request $request)
    {
        if (!Permissions::getRolePermissions('dailySales')) {
            abort(403, 'Unauthorized action.');
        }
        $parts = explode('-', $request['month']);
        return json_encode($this->drawTable($parts[1], $parts[0]));
    }

    public function drawTable($month, $year, $type = 'invoice')
    {
        /* draw table */
        $calendar = '<table id="manageTable" cellpadding="0" cellspacing="0" class="table table-bordered calendar">';

        /* table headings */
        $headings = array('Sunday' . $type, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
        $calendar .= '<tr class="calendar-row"><td class="calendar-day-head">' . implode('</td><td class="calendar-day-head">', $headings) . '</td></tr>';

        /* days and weeks vars now ... */
        $running_day = date('w', mktime(0, 0, 0, $month, 1, $year));
        $days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
        $days_in_this_week = 1;
        $day_counter = 0;
        $dates_array = array();

        /* row for week one */
        $calendar .= '<tr class="calendar-row">';

        /* print "blank" days until the first of the current week */
        for ($x = 0; $x < $running_day; $x++):
            $calendar .= '<td class="calendar-day-np"> </td>';
            $days_in_this_week++;
        endfor;

        /* keep going with days.... */
        for ($list_day = 1; $list_day <= $days_in_month; $list_day++):
            $calendar .= '<td class="calendar-day" >';
            /* add in the day number */
            $calendar .= '<div class="day-number">' . $list_day . '</div>';
            $outData = '';
            $outData = ($type == 'invoice') ? $this->dayToDrawSummary($list_day, $month, $year) : $this->POdayToDrawSummary($list_day, $month, $year);

            /** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
            $calendar .= str_repeat('<p>' . $outData . '</p>', 1);

            $calendar .= '</td>';
            if ($running_day == 6):
                $calendar .= '</tr>';
                if (($day_counter + 1) != $days_in_month):
                    $calendar .= '<tr class="calendar-row">';
                endif;
                $running_day = -1;
                $days_in_this_week = 0;
            endif;
            $days_in_this_week++;
            $running_day++;
            $day_counter++;
        endfor;

        /* finish the rest of the days in the week */
        if ($days_in_this_week < 8):
            for ($x = 1; $x <= (8 - $days_in_this_week); $x++):
                $calendar .= '<td class="calendar-day-np"> </td>';
            endfor;
        endif;

        /* final row */
        $calendar .= '</tr>';

        /* end the table */
        $calendar .= '</table>';

        /* all done, return result */
        return $calendar;
    }

    public function dayToDrawSummary($day, $month, $year)
    {
        $invoices = Invoice::
        whereDay('invoice_date', '=', $day)
            ->whereMonth('invoice_date', '=', $month)
            ->whereYear('invoice_date', '=', $year)
            ->get();

        $discount = 0;
        $orderDiscount = 0;
        $orderTax = 0;
        $total = 0;
        $productTax = 0;
        $productsCost = 0;
        $productsRevenue = 0;

        if (count($invoices) == 0) {
            return '';
        }

        foreach ($invoices as $invoice) {
            $discount += $invoice->discount;
            $orderDiscount += $invoice->discount;

            foreach ($invoice->invoiceItems as $invoiceItem) {
                $productTax += $invoiceItem->tax_val * $invoiceItem->qty;
                $discount += $invoiceItem->discount;
                $productsCost += $invoiceItem->qty * $invoiceItem->products->cost_price;
                $productsRevenue += $invoiceItem->sub_total;
            }

            $orderTax += $invoice->tax_amount;
            $total += $invoice->invoice_grand_total;
        }

        return $table = '<table class="table table-bordered table-striped table-hover">
                        <tr><td>Discount</td><td style="text-align: right">' . number_format($discount, 2) . '</td></tr>
                        <tr><td>Product Tax</td><td style="text-align: right">' . number_format($productTax, 2) . '</td></tr>
                        <tr><td>Order Tax</td><td style="text-align: right">' . number_format($orderTax, 2) . '</td></tr>
                        <tr><td>Total</td><td style="text-align: right">' . number_format($total, 2) . '</td></tr>
                        </table>
                        <div class="row2 collapse multi-collapse" id="multiCollapseExample_' . $day . '-' . $month . '-' . $year . '">
                        <table class="table table-bordered table-striped table-hover">
                        <tr><td>Products Revenue</td><td style="text-align: right">' . number_format($productsRevenue, 2) . '</td></tr>
                        <tr><td>Order Discount</td><td style="text-align: right">' . number_format($orderDiscount, 2) . '</td></tr>
                        <tr><td>Product Cost</td><td style="text-align: right">' . number_format($productsCost, 2) . '</td></tr>
                        <tr style="font-weight: bold"><td >Profit</td><td style="text-align: right">' . number_format((($productsRevenue - $orderDiscount) - $productsCost), 2) . '</td></tr>
                        </table>
                        </div><span style="float: right"><button class="btn btn-xs btn-success" type="button" data-toggle="collapse"
                                data-target="#multiCollapseExample_' . $day . '-' . $month . '-' . $year . '" aria-expanded="false"
                                aria-controls="multiCollapseExample_' . $day . '-' . $month . '-' . $year . '"><i class="fa fa-fw fa-search"></i>More</button></span>';
    }

    public function POdayToDrawSummary($day, $month, $year)
    {
        $pos = PO::
        whereDay('due_date', '=', $day)
            ->whereMonth('due_date', '=', $month)
            ->whereYear('due_date', '=', $year)
            ->get();

        $discount = 0;
        $orderDiscount = 0;
        $orderTax = 0;
        $total = 0;
        $productTax = 0;
        $productsCost = 0;
        $productsRevenue = 0;

        if (count($pos) == 0) {
            return '';
        }

        foreach ($pos as $po) {
            $discount += $po->discount;
//            $orderDiscount += $po->discount;

            foreach ($po->poDetails as $poItem) {
                $productTax += $poItem->tax_val * $poItem->qty;
                $discount += $poItem->discount;
                $productsCost += $poItem->qty * $poItem->product->cost_price;
                $productsRevenue += $poItem->sub_total;
            }

            $orderTax += $po->tax;
            $total += $po->grand_total;
        }

        return $table = '<table class="table table-bordered table-striped table-hover">
                        <tr><td>Discount</td><td style="text-align: right">' . number_format($discount, 2) . '</td></tr>
                        <tr><td>Product Tax</td><td style="text-align: right">' . number_format($productTax, 2) . '</td></tr>
                        <tr><td>Order Tax</td><td style="text-align: right">' . number_format($orderTax, 2) . '</td></tr>
                        <tr><td>Total</td><td style="text-align: right">' . number_format($total, 2) . '</td></tr>
                        </table>';
    }

    public function monthlySalesIndex()
    {
        if (!Permissions::getRolePermissions('monthlySales')) {
            abort(403, 'Unauthorized action.');
        }
        $yearMonth = date('Y');
        $table = $this->drawMonthTable(date('Y'));

        return view('vendor.adminlte.reports.monthlySalesReport.index', ['table' => $table, 'yearMonth' => $yearMonth]);
    }

    public function monthlySalesForMonth(Request $request)
    {
        if (!Permissions::getRolePermissions('monthlySales')) {
            abort(403, 'Unauthorized action.');
        }
//        $parts = explode('-', $request['month']);
        return json_encode($this->drawMonthTable($request['year']));
    }

    public function drawMonthTable($year, $type = 'invoice')
    {
        /* draw table */
        $calendar = '<table id="manageTable" cellpadding="0" cellspacing="0" class="table table-bordered calendar">';

        /* table headings */
        $headings = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $calendar .= '<tr class="calendar-row"><td class="calendar-day-head">' . implode('</td><td class="calendar-day-head">', $headings) . '</td></tr>';


        $months = 1;
        $month_counter = 0;
        $dates_array = array();

        /* row for week one */
        $calendar .= '<tr class="calendar-row">';


        /* print "blank" days until the first of the current week */
        for ($x = 1; $x < 13; $x++):
            $outData = '';
            $outData = ($type == 'invoice') ? $this->monthToDrawSummary($x, $year) : $this->POmonthToDrawSummary($x, $year);

            $calendar .= '<td class="calendar-day-np">';
            $calendar .= str_repeat('<p>' . $outData . '</p>', 1);
            $calendar .= '</td>';
            $months++;
        endfor;


        /* final row */
        $calendar .= '</tr>';

        /* end the table */
        $calendar .= '</table>';

        /* all done, return result */
        return $calendar;
    }

    public function monthToDrawSummary($month, $year)
    {
        $invoices = Invoice::
        whereBetween('invoice_date', [$year . '-' . $month . '-01', $year . '-' . $month . '-31'])
//            whereMonth('invoice_date', '=', $month)
//            ->whereYear('invoice_date', '=', $year)
            ->get();

        $discount = 0;
        $orderDiscount = 0;
        $orderTax = 0;
        $total = 0;
        $productTax = 0;
        $productsCost = 0;
        $productsRevenue = 0;

        if (count($invoices) == 0) {
            return '';
        }

        foreach ($invoices as $invoice) {
            $discount += $invoice->discount;
            $orderDiscount += $invoice->discount;

            foreach ($invoice->invoiceItems as $invoiceItem) {
                $productTax += $invoiceItem->tax_val * $invoiceItem->qty;
                $discount += $invoiceItem->discount;
                $productsCost += $invoiceItem->qty * $invoiceItem->products->cost_price;
                $productsRevenue += $invoiceItem->sub_total;
            }

            $orderTax += $invoice->tax_amount;
            $total += $invoice->invoice_grand_total;
        }

        return $table = '<table class="table table-bordered table-striped table-hover">
                        <tr><td>Discount</td><td style="text-align: right">' . number_format($discount, 2) . '</td></tr>
                        <tr><td>Product Tax</td><td style="text-align: right">' . number_format($productTax, 2) . '</td></tr>
                        <tr><td>Order Tax</td><td style="text-align: right">' . number_format($orderTax, 2) . '</td></tr>
                        <tr><td>Total</td><td style="text-align: right">' . number_format($total, 2) . '</td></tr>
                        </table>
                        <div class="row2 collapse multi-collapse" id="multiCollapseExample_' . $month . '-' . $year . '">
                        <table class="table table-bordered table-striped table-hover">
                        <tr><td>Products Revenue</td><td style="text-align: right">' . number_format($productsRevenue, 2) . '</td></tr>
                        <tr><td>Order Discount</td><td style="text-align: right">' . number_format($orderDiscount, 2) . '</td></tr>
                        <tr><td>Product Cost</td><td style="text-align: right">' . number_format($productsCost, 2) . '</td></tr>
                        <tr style="font-weight: bold"><td >Profit</td><td style="text-align: right">' . number_format((($productsRevenue - $orderDiscount) - $productsCost), 2) . '</td></tr>
                        </table>
                        </div><span style="float: right"><button class="btn btn-xs btn-success" type="button" data-toggle="collapse"
                                data-target="#multiCollapseExample_' . $month . '-' . $year . '" aria-expanded="false"
                                aria-controls="multiCollapseExample_' . $month . '-' . $year . '"><i class="fa fa-fw fa-search"></i>More</button></span>';
    }

    public function POmonthToDrawSummary($month, $year)
    {
        $pos = PO::
        whereBetween('due_date', [$year . '-' . $month . '-01', $year . '-' . $month . '-31'])
//            whereMonth('invoice_date', '=', $month)
//            ->whereYear('invoice_date', '=', $year)
            ->get();

        $discount = 0;
        $orderDiscount = 0;
        $orderTax = 0;
        $total = 0;
        $productTax = 0;
        $productsCost = 0;
        $productsRevenue = 0;

        if (count($pos) == 0) {
            return '';
        }

        foreach ($pos as $po) {
            $discount += $po->discount;
            $orderDiscount += $po->discount;

            foreach ($po->poDetails as $poDetail) {
                $productTax += $poDetail->tax_val * $poDetail->qty;
                $discount += $poDetail->discount;
                $productsCost += $poDetail->qty * $poDetail->product->cost_price;
                $productsRevenue += $poDetail->sub_total;
            }

            $orderTax += $po->tax;
            $total += $po->grand_total;
        }

        return $table = '<table class="table table-bordered table-striped table-hover">
                        <tr><td>Discount</td><td style="text-align: right">' . number_format($discount, 2) . '</td></tr>
                        <tr><td>Product Tax</td><td style="text-align: right">' . number_format($productTax, 2) . '</td></tr>
                        <tr><td>Order Tax</td><td style="text-align: right">' . number_format($orderTax, 2) . '</td></tr>
                        <tr><td>Total</td><td style="text-align: right">' . number_format($total, 2) . '</td></tr>
                        </table>';
    }

    public function last5Sales()
    {
        $invoices = Invoice::latest()->limit(5)->get();
        $array = [];
        foreach ($invoices as $key => $invoice) {
            $array[$key]['id'] = $invoice->id;
            $array[$key]['invoice_date'] = $invoice->invoice_date;
            $array[$key]['invoice_code'] = $invoice->invoice_code;
            $array[$key]['cus_name'] = $invoice->customers->name;
            $array[$key]['sales_status'] = $invoice->sales_status;
            $array[$key]['invoice_grand_total'] = number_format($invoice->invoice_grand_total, 2);
            $array[$key]['payment_status'] = $invoice->payment_status;

            $payments = new PaymentsController();
            $paid = $payments->refCodeByGetOutstanding($invoice->invoice_code);
            $array[$key]['paid'] = number_format($paid, 2);

        }
        return $array;
    }

    public function last5Purcheses()
    {
        $pos = PO::latest()->limit(5)->get();
        $array = [];
        foreach ($pos as $key => $po) {
            $array[$key]['id'] = $po->id;
            $array[$key]['date'] = $po->due_date;
            $array[$key]['referenceCode'] = $po->referenceCode;
            $array[$key]['sup_name'] = $po->suppliers->name;
            $array[$key]['status'] = $po->status;
            $array[$key]['grand_total'] = number_format($po->grand_total, 2);
        }
        return $array;
    }

    public function last5Transfers()
    {
        $tras = Transfers::latest()->limit(5)->get();
        $array = [];
        foreach ($tras as $key => $tra) {
            $array[$key]['id'] = $tra->id;
            $array[$key]['date'] = $tra->tr_date;
            $array[$key]['referenceCode'] = $tra->tr_reference_code;
            $array[$key]['from'] = $tra->fromLocation->name;
            $array[$key]['to'] = $tra->toLocation->name;
            $array[$key]['status'] = $tra->status;
            $array[$key]['total'] = number_format($tra->grand_total, 2);
        }
        return $array;
    }

    public function last5Customers()
    {
        $cuss = Customer::latest()->limit(5)->get();
        $array = [];
        foreach ($cuss as $key => $cus) {
            $array[$key]['id'] = $cus->id;
            $array[$key]['company'] = $cus->company;
            $array[$key]['name'] = $cus->name;
            $array[$key]['email'] = $cus->email;
            $array[$key]['phone'] = $cus->phone;
            $array[$key]['address'] = $cus->address;
        }
        return $array;
    }

    public function last5Suppliers()
    {
        $sups = Supplier::latest()->limit(5)->get();
        $array = [];
        foreach ($sups as $key => $sup) {
            $array[$key]['id'] = $sup->id;
            $array[$key]['company'] = $sup->company;
            $array[$key]['name'] = $sup->name;
            $array[$key]['email'] = $sup->email;
            $array[$key]['phone'] = $sup->phone;
            $array[$key]['address'] = $sup->address;
        }
        return $array;
    }

    public function chartData()
    {

        $months = array(
            0 => date('m', strtotime('-2 month')),
            1 => date('m', strtotime('-1 month')),
            2 => date('m'),
        );

        $array = array();
        foreach ($months as $key => $month) {

            $invoices = Invoice::whereMonth('invoice_date', '=', $month)->get();
            $soldProductTax = 0;
            $orderTax = 0;
            $sales = 0;
            foreach ($invoices as $invoice) {
                foreach ($invoice->invoiceItems as $invo) {
                    $soldProductTax += $invo->tax_val;
                }
                $orderTax += $invoice->tax_amount;
                $sales += $invoice->invoice_grand_total;
            }
            $array[$key]['soldProductTax'] = $soldProductTax;
            $array[$key]['orderTax'] = $orderTax;
            $array[$key]['sales'] = $sales - $soldProductTax;

            $purs = PO::whereMonth('due_date', '=', $month)->get();

            $poProductTax = 0;
            $poValue = 0;
            foreach ($purs as $pur) {
                foreach ($pur->poDetails as $pod) {
                    $poProductTax += $pod->tax_val;
                }
                $poValue += $pur->grand_total;
            }
            $array[$key]['purchases'] = $poValue;
            $array[$key]['purchaseProductTax'] = $poProductTax;
            if ($key == 0) {
                $array[$key]['month'] = date('F', strtotime('-2 month')) . '-' . date('Y');
            } elseif ($key == 1) {
                $array[$key]['month'] = date('F', strtotime('-1 month')) . '-' . date('Y');
            } elseif ($key == 2) {
                $array[$key]['month'] = date('F', strtotime('0 month')) . '-' . date('Y');
            }

        }
        return $array;

    }

    public function notifications()
    {
        $array = array();

        if (Permissions::getRolePermissions('notifications')) {
//            if (Permissions::getRolePermissions('quantityAlerts') === true) {
            $array['stock'] = $this->stockNotification();
//            }
//            if (Permissions::getRolePermissions('newRegisteredUsers') ) {
            $array['guests'] = $this->guestsCount(); // email verified count of guests
//            }
        }

        return $array;
    }

    public function stockNotification()
    {
        $stock = new  StockController();
        $data = (object)Products::where(['status' => \Config::get('constants.status.Active')])->get();
        $in = 0;
        foreach ($data as $key => $product) {
            if ($product->reorder_activation == \Config::get('constants.status.Active')) {

                $qty = json_decode($stock->itemQtySumNoteDeletedWareHouses($product->id));

                if ($product->reorder_level >= $qty) {
                    $in++;
                }
            }
        }
        return $in;
    }

    public function guestsCount()
    {
        $user = new User();
        $user = $user->whereHas('roles', function ($query) {
            $query->where('roles.name', 'Guest')->where('email_verified_at', '!=', null);
        });

        return $user->count();
    }

    public function salesIndex(Request $request)
    {
        if (!Permissions::getRolePermissions('salesReport')) {
            abort(403, 'Unauthorized action.');
        }
        $soldUsers = Invoice::groupBy('created_by')->get();
        $customers = Customer::where(['status' => \Config::get('constants.status.Active')])->get();
        $billers = Biller::where(['status' => \Config::get('constants.status.Active')])->get();
        $locations = Locations::where(['status' => \Config::get('constants.status.Active')])->get();
        $products = Products::where(['status' => \Config::get('constants.status.Active')])->get();

        $sale = new Invoice();
//        $sale =  $sale->invoiceItems->where('item_id',1);
        if (isset($request->product) && $request->product != '0') {
            $sale = $sale->whereHas('invoiceItems', function ($query) use ($request) {
                $query->where('item_id', [$request->product]);
            });
        }
        if (isset($request->ref) && $request->ref != '') {
            $sale = $sale->where('invoice_code', 'LIKE', "%" . $request->ref . "%");
        }
        if (isset($request->createdUser) && $request->createdUser != '0') {
            $sale = $sale->where('created_by', $request->createdUser);
        }
        if (isset($request->customer) && $request->customer != '0') {
            $sale = $sale->where('customer', $request->customer);
        }
        if (isset($request->biller) && $request->biller != '0') {
            $sale = $sale->where('biller', $request->biller);
        }
        if (isset($request->warehouse) && $request->warehouse != '0') {
            $sale = $sale->where('location', $request->warehouse);
        }
        if ((isset($request->from) && $request->from != '') && (isset($request->to) && $request->to != '')) {
            $sale = $sale->whereBetween('created_at', array($request->from, $request->to));
        }
//        echo $foo_sql = $sale->toSql();
        $filteredData = $sale->get();
//        dd(DB::getQueryLog());
        return view('vendor.adminlte.reports.salesReport.index', ['filteredData' => $filteredData, 'soldUsers' => $soldUsers, 'warehouses' => $locations, 'billers' => $billers, 'customers' => $customers, 'products' => $products]);
    }

    public function purchasesIndex(Request $request)
    {
        if (!Permissions::getRolePermissions('purchasesReport')) {
            abort(403, 'Unauthorized action.');
        }
        $poUsers = PO::groupBy('created_by')->get();
        $suppliers = Supplier::where(['status' => \Config::get('constants.status.Active')])->get();
        $locations = Locations::where(['status' => \Config::get('constants.status.Active')])->get();
        $products = Products::where(['status' => \Config::get('constants.status.Active')])->get();

        $pos = new PO();
//        $pos =  $pos->invoiceItems->where('item_id',1);
        if (isset($request->product) && $request->product != '0') {
            $pos = $pos->whereHas('poDetails', function ($query) use ($request) {
                $query->where('item_id', [$request->product]);
            });
        }
        if (isset($request->ref) && $request->ref != '') {
            $pos = $pos->where('referenceCode', 'LIKE', "%" . $request->ref . "%");
        }
        if (isset($request->createdUser) && $request->createdUser != '0') {
            $pos = $pos->where('created_by', $request->createdUser);
        }
        if (isset($request->supplier) && $request->supplier != '0') {
            $pos = $pos->where('supplier', $request->supplier);
        }
        if (isset($request->warehouse) && $request->warehouse != '0') {
            $pos = $pos->where('location', $request->warehouse);
        }
        if ((isset($request->from) && $request->from != '') && (isset($request->to) && $request->to != '')) {
            $pos = $pos->whereBetween('created_at', array($request->from, $request->to));
        }
//        echo $foo_sql = $pos->toSql();
        $filteredData = $pos->get();
//        dd(DB::getQueryLog());
        return view('vendor.adminlte.reports.purchasesReport.index', ['filteredData' => $filteredData, 'soldUsers' => $poUsers, 'warehouses' => $locations, 'suppliers' => $suppliers, 'products' => $products]);
    }

    public function paymentIndex(Request $request)
    {
        if (!Permissions::getRolePermissions('paymentsReport')) {
            abort(403, 'Unauthorized action.');
        }
        $payUsers = Payments::groupBy('created_by')->get();
        $customers = Customer::where(['status' => \Config::get('constants.status.Active')])->get();
        $billers = Biller::where(['status' => \Config::get('constants.status.Active')])->get();
        $supplier = Supplier::where(['status' => \Config::get('constants.status.Active')])->get();
        $products = Products::where(['status' => \Config::get('constants.status.Active')])->get();

        $payment = new Payments();
        if (isset($request->payRef) && $request->payRef != '') {
            $payment = $payment->where('reference_code', 'LIKE', "%" . $request->payRef . "%");
        }
        if (isset($request->payBy) && $request->payBy != '0') {
            $payment = $payment->where('pay_type', $request->payBy);
        }
        if (isset($request->cNumber) && $request->cNumber != '') {
            $payment = $payment->where(' cheque_no', $request->cNumber);
        }
        if (isset($request->createdUser) && $request->createdUser != '0') {
            $payment = $payment->where('created_by', $request->createdUser);
        }
        if ((isset($request->from) && $request->from != '') && (isset($request->to) && $request->to != '')) {
            $payment = $payment->whereBetween('created_at', array($request->from, $request->to));
        }


        $filteredData = $payment->get();

        $out = array();
        $cusKey = 0;
        foreach ($filteredData as $key => $pay) {

            switch (substr($pay->parent_reference_code, 0, 2)):
                case 'PO':
                    $poData = new PO();
                    $poData = $poData->where('referenceCode', $pay->parent_reference_code);
                    /*po searching*/
                    if (isset($request->purRef) && $request->purRef != '') {
                        $poData = $poData->where('referenceCode', 'LIKE', "%" . $request->purRef . "%");
                    }
                    if (isset($request->supplier) && $request->supplier != '0') {
                        $poData = $poData->where('supplier', $request->supplier);
                    }

                    $poData = $poData->get();

                    if ($poData->isNotEmpty()) {

                        $out[$cusKey]['id'] = $pay->id;
                        $out[$cusKey]['date'] = $pay->date;
                        $out[$cusKey]['paymentReference'] = $pay->reference_code;
                        $out[$cusKey]['saleReference'] = '';
                        $out[$cusKey]['purReference'] = $pay->parent_reference_code;
                        $out[$cusKey]['paidBy'] = $pay->pay_type;
                        $out[$cusKey]['amount'] = $pay->value;
                        $out[$cusKey]['type'] = $pay->pay_type;
                        $out[$cusKey]['lastUpdated'] = $pay->updated_at;
//                        $out[$cusKey]['typeeee'] = 'pooooo';
                        ++$cusKey;
                    }
                    break;
                case 'IV':
                    $ivData = new Invoice();
                    $ivData = $ivData->where('invoice_code', $pay->parent_reference_code);
                    /*invoice searching*/
                    if (isset($request->saleRef) && $request->saleRef != '') {
                        $ivData = $ivData->where('invoice_code', 'LIKE', "%" . $request->saleRef . "%");
                    }
                    if (isset($request->customer) && $request->customer != '0') {
                        $ivData = $ivData->where('customer', $request->customer);
                    }
                    if (isset($request->biller) && $request->biller != '0') {
                        $ivData = $ivData->where('biller', $request->biller);
                    }
                    $ivData = $ivData->get();

                    if ($ivData->isNotEmpty()) {
                        $out[$cusKey]['id'] = $pay->id;
                        $out[$cusKey]['date'] = $pay->date;
                        $out[$cusKey]['paymentReference'] = $pay->reference_code;
                        $out[$cusKey]['saleReference'] = $pay->parent_reference_code;
                        $out[$cusKey]['purReference'] = '';
                        $out[$cusKey]['paidBy'] = $pay->pay_type;
                        $out[$cusKey]['amount'] = $pay->value;
                        $out[$cusKey]['lastUpdated'] = $pay->updated_at;
//                        $out[$cusKey]['typeeee'] = 'invoice';
                        ++$cusKey;
                    }

                    break;
            endswitch;

        }
//        echo $foo_sql = $poData->toSql();
//        echo '<pre>';
//        print_r($out);
//        echo '</pre>';
        return view('vendor.adminlte.reports.paymentReport.index', ['filteredData' => $out, 'payUsers' => $payUsers, 'suppliers' => $supplier, 'billers' => $billers, 'customers' => $customers, 'products' => $products]);
    }

    public function dailyPurchasesIndex(Request $request)
    {
        if (!Permissions::getRolePermissions('dailyPurchases')) {
            abort(403, 'Unauthorized action.');
        }
        $yearMonth = date('Y-m');
        $table = $this->drawTable(date('m'), date('Y'), 'po');

        return view('vendor.adminlte.reports.dailyPurchasesReport.index', ['table' => $table, 'yearMonth' => $yearMonth]);
    }

    public function dailyPurchasesForMonth(Request $request)
    {
        if (!Permissions::getRolePermissions('dailyPurchases')) {
            abort(403, 'Unauthorized action.');
        }
        $parts = explode('-', $request['month']);
        return json_encode($this->drawTable($parts[1], $parts[0], 'po'));
    }

    public function monthlyPurchasesIndex()
    {
        if (!Permissions::getRolePermissions('monthlyPurchases')) {
            abort(403, 'Unauthorized action.');
        }
        $yearMonth = date('Y');
        $table = $this->drawMonthTable(date('Y'), 'po');

        return view('vendor.adminlte.reports.monthlyPurchasesReport.index', ['table' => $table, 'yearMonth' => $yearMonth]);
    }

    public function monthlyPurchasesForMonth(Request $request)
    {
        if (!Permissions::getRolePermissions('monthlyPurchases')) {
            abort(403, 'Unauthorized action.');
        }
        return json_encode($this->drawMonthTable($request['year'], 'po'));
    }

    public function customersView(Request $request)
    {
        if (!Permissions::getRolePermissions('customersReport')) {
            abort(403, 'Unauthorized action.');
        }
        return view('vendor.adminlte.reports.customersReport.index');
    }

    public function suppliersView(Request $request)
    {
        if (!Permissions::getRolePermissions('suppliersReport')) {
            abort(403, 'Unauthorized action.');
        }
        return view('vendor.adminlte.reports.suppliersReport.index');
    }

    public function fetchCustomersData(Request $request)
    {
        if (!Permissions::getRolePermissions('customersReport')) {
            abort(403, 'Unauthorized action.');
        }
        $list = array();

        $customers = Invoice::with('customers')->where('status', \Config::get('constants.status.Active'))->groupBy('customer');

        if ((isset($request['from']) && $request['from']) && (isset($request['to']) && $request['to'])) {
            $customers = $customers->whereBetween('invoice_date', array($request['from'], $request['to']));
        }

        $customers = $customers->get();

        $saleCount = 0;
        $totAmount = 0;
        $paid = 0;
        foreach ($customers as $key => $customer) {
            $customerInvoices = Invoice::where('status', \Config::get('constants.status.Active'))->where('customer', $customer->customer)->get();
            foreach ($customerInvoices as $customerInvoice) {
                ++$saleCount;
                $totAmount += $customerInvoice->invoice_grand_total;
                $paid += $customerInvoice->paid;
            }
            $list['data'][$key] = array(
                'company' => $customer->customers->company,
                'name' => $customer->customers->name,
                'phone' => $customer->customers->phone,
                'email' => $customer->customers->email,
                'saleCount' => $saleCount,
                'totAmount' => number_format($totAmount, 2),
                'paid' => number_format($paid, 2),
                'balance' => number_format(($totAmount - $paid), 2),
                'action' => "<a class=\"btn btn-primary  btn-xs\" href=\"customer_report/" . $customer->customer . "\" role=\"button\">View Report</a>"
            );
        }

        echo json_encode((isset($list['data']) ? $list : array('data' => array())));
    }

    public function fetchSuppliersData(Request $request)
    {
        if (!Permissions::getRolePermissions('suppliersReport')) {
            abort(403, 'Unauthorized action.');
        }
        $list = array();

        $suppliers = PO::with('suppliers')->groupBy('supplier');

        if ((isset($request['from']) && $request['from']) && (isset($request['to']) && $request['to'])) {
            $suppliers = $suppliers->whereBetween('due_date', array($request['from'], $request['to']));
        }

        $suppliers = $suppliers->get();
        $saleCount = 0;
        $totAmount = 0;
        $paid = 0;
        foreach ($suppliers as $key => $supplier) {
            $supplierPOS = PO::where('supplier', $supplier->supplier)->get();
            foreach ($supplierPOS as $supplierPO) {
                ++$saleCount;
                $totAmount += $supplierPO->grand_total;
                $paid += $supplierPO->paid;
            }
            $list['data'][$key] = array(
                'company' => $supplier->suppliers->company,
                'name' => $supplier->suppliers->name,
                'phone' => $supplier->suppliers->phone,
                'email' => $supplier->suppliers->email,
                'saleCount' => $saleCount,
                'totAmount' => number_format($totAmount, 2),
                'paid' => number_format($paid, 2),
                'balance' => number_format(($totAmount - $paid), 2),
                'action' => "<a class=\"btn btn-primary  btn-xs\" href=\"supplier_report/" . $supplier->supplier . "\" role=\"button\">View Report</a>"
            );
        }

        echo json_encode((isset($list['data']) ? $list : array('data' => array())));
    }

    public function customerDetails(Request $request, $id)
    {
        if (!Permissions::getRolePermissions('customersReport')) {
            abort(403, 'Unauthorized action.');
        }
        $soldUsers = Invoice::groupBy('created_by')->get();
        $payUsers = Payments::groupBy('created_by')->get();
        $billers = Biller::where(['status' => \Config::get('constants.status.Active')])->get();
        $locations = Locations::where(['status' => \Config::get('constants.status.Active')])->get();

        $totPaid = $this->customerPaid($id);
        $totSale = $this->customerForSale($id);

        $heaeder = array(
            'saleAmount' => number_format($totSale, 2),
            'totPaid' => number_format($totPaid, 2),
            'dueAmount' => number_format($totSale - $totPaid, 2),
            'totSale' => $this->customerForSaleCount($id),
        );


        return view('vendor.adminlte.reports.customersReport.customerReport.index', ['header' => $heaeder, 'soldUsers' => $soldUsers, 'payUsers' => $payUsers, 'warehouses' => $locations, 'billers' => $billers]);
    }

    public function suppliersDetails(Request $request, $id)
    {
        if (!Permissions::getRolePermissions('suppliersReport')) {
            abort(403, 'Unauthorized action.');
        }
        $soldUsers = PO::groupBy('created_by')->get();
        $locations = Locations::where(['status' => \Config::get('constants.status.Active')])->get();

        $totPaid = $this->supplierToPaid($id);
        $totPur = $this->supplierForPurchases($id);

        $heaeder = array(
            'saleAmount' => number_format($totPur, 2),
            'totPaid' => number_format($totPaid, 2),
            'dueAmount' => number_format($totPur - $totPaid, 2),
            'totPur' => $this->supplierForPurchasesCount($id),
        );


        return view('vendor.adminlte.reports.suppliersReport.customerReport.index', ['header' => $heaeder, 'soldUsers' => $soldUsers, 'warehouses' => $locations]);
    }

    public function customerForSale($id)
    {
        $sum = Invoice::where('customer', $id)->sum('invoice_grand_total');
        return $sum;
    }

    public function customerForSaleCount($id)
    {
        $sum = Invoice::where('customer', $id)->count();
        return $sum;
    }

    public function supplierForPurchases($id)
    {
        $sum = PO::where('supplier', $id)->sum('grand_total');
        return $sum;
    }

    public function supplierForPurchasesCount($id)
    {
        $sum = PO::where('supplier', $id)->count();
        return $sum;
    }

    public function customerPaid($id)
    {
        $invoices = Invoice::where('customer', $id)->get();
        $sum = 0;
        foreach ($invoices as $invo) {
            $sum += $invo->paid;
        }
        return $sum;
    }

    public function supplierToPaid($id)
    {
        $pos = PO::where('supplier', $id)->get();
        $sum = 0;
        foreach ($pos as $po) {
            $sum += $po->paid;
        }
        return $sum;
    }

    public function fetchCustomerSaleData(Request $request)
    {
        if (!Permissions::getRolePermissions('customersReport')) {
            abort(403, 'Unauthorized action.');
        }
        $sale = new Invoice();

        if (isset($request->saleCreatedUser) && $request->saleCreatedUser != '0') {
            $sale = $sale->where('created_by', $request->saleCreatedUser);
        }
        if (isset($request->customerId) && $request->customerId != '0') {
            $sale = $sale->where('customer', $request->customerId);
        }

        if (isset($request->saleBiller) && $request->saleBiller != '0') {
            $sale = $sale->where('biller', $request->saleBiller);
        }
        if (isset($request->saleWarehouse) && $request->saleWarehouse != '0') {
            $sale = $sale->where('location', $request->saleWarehouse);
        }
        if ((isset($request->SaleFrom) && $request->SaleFrom != '') && (isset($request->SaleTo) && $request->SaleTo != '')) {
            $sale = $sale->whereBetween('invoice_date', array($request->SaleFrom, $request->SaleTo));
        }
//        echo $foo_sql = $sale->toSql();
        $filteredData = $sale->get();

        $list = array();
        foreach ($filteredData as $key => $invoice) {

            $products = "";

            foreach ($invoice->invoiceItems as $invoItem) {
                $products .= $invoItem->products->name . '(' . $invoItem->qty . ')' . '<br>';
            }
            switch ($invoice->payment_status):
                case 1:
                    $payStatus = '<span class="label label-warning">pending</span>';
                    break;
                case 2:
                    $payStatus = '<span class="label label-warning">Due</span>';
                    break;
                case 3:
                    $payStatus = '<span class="label label-warning">Partial</span>';
                    break;
                case 4:
                    $payStatus = '<span class="label label-success">Paid</span>';
                    break;
                case 5:
                    $payStatus = '<span class="label label-danger">Over Paid</span>';
                    break;
                default:
                    $payStatus = '<span class="label label-danger">Nothing</span>';
                    break;
            endswitch;

            $list['data'][$key] = array(
                'date' => $invoice->invoice_date,
                'reference' => $invoice->invoice_code,
                'biller' => $invoice->billers->name,
                'products' => $products,
                'grandTotal' => number_format($invoice->invoice_grand_total, 2),
                'paid' => number_format($invoice->paid, 2),
                'balance' => number_format($invoice->invoice_grand_total - $invoice->paid, 2),
                'paymentStatus' => $payStatus,
            );
        }
        echo json_encode((isset($list['data']) ? $list : array('data' => array())));
    }

    public function fetchSuppliersPurData(Request $request)
    {
        if (!Permissions::getRolePermissions('suppliersReport')) {
            abort(403, 'Unauthorized action.');
        }
        $pos = new PO();

        if (isset($request->saleCreatedUser) && $request->saleCreatedUser != '0') {
            $pos = $pos->where('created_by', $request->saleCreatedUser);
        }
        if (isset($request->supplierId) && $request->supplierId != '0') {
            $pos = $pos->where('supplier', $request->supplierId);
        }

        if (isset($request->saleWarehouse) && $request->saleWarehouse != '0') {
            $pos = $pos->where('location', $request->saleWarehouse);
        }
        if ((isset($request->SaleFrom) && $request->SaleFrom != '') && (isset($request->SaleTo) && $request->SaleTo != '')) {
            $pos = $pos->whereBetween('due_date', array($request->SaleFrom, $request->SaleTo));
        }
//        echo $foo_sql = $pos->toSql();
        $filteredData = $pos->get();

        $list = array();
        foreach ($filteredData as $key => $po) {

            $products = "";

            foreach ($po->poDetails as $poItem) {
                $products .= $poItem->product->name . '(' . $poItem->qty . ')' . '<br>';
            }
            switch ($po->payment_status):
                case 1:
                    $payStatus = '<span class="label label-warning">pending</span>';
                    break;
                case 2:
                    $payStatus = '<span class="label label-warning">Due</span>';
                    break;
                case 3:
                    $payStatus = '<span class="label label-warning">Partial</span>';
                    break;
                case 4:
                    $payStatus = '<span class="label label-success">Paid</span>';
                    break;
                case 5:
                    $payStatus = '<span class="label label-danger">Over Paid</span>';
                    break;
                default:
                    $payStatus = '<span class="label label-danger">Nothing</span>';
                    break;
            endswitch;

            $list['data'][$key] = array(
                'date' => $po->due_date,
                'reference' => $po->referenceCode,
                'warehouse' => $po->locations->name,
                'products' => $products,
                'grandTotal' => number_format($po->grand_total, 2),
                'paid' => number_format($po->paid, 2),
                'balance' => number_format($po->grand_total - $po->paid, 2),
                'paymentStatus' => $payStatus,
            );
        }
        echo json_encode((isset($list['data']) ? $list : array('data' => array())));
    }

    public function fetchCustomerPaymentData(Request $request)
    {
        if (!Permissions::getRolePermissions('customersReport')) {
            abort(403, 'Unauthorized action.');
        }
        $payment = new Payments();
        if (isset($request->customerId) && $request->customerId != '0') {
            $payment = $payment->whereHas('invoices', function ($query) use ($request) {
                $query->where('customer', [$request->customerId]);
            });
        }
        if ((isset($request->payFrom) && $request->payFrom != '') && (isset($request->payTo) && $request->payTo != '')) {
            $payment = $payment->whereBetween('created_at', array($request->payFrom, $request->payTo));
        }
//        echo $foo_sql = $payment->toSql();

        $filteredData = $payment->get();

        $list = array();
        foreach ($filteredData as $key => $payment) {
            $list['data'][$key] = array(
                'date' => $payment->date,
                'payReference' => $payment->reference_code,
                'saleReference' => $payment->parent_reference_code,
                'paidBy' => $payment->pay_type,
                'amount' => number_format($payment->value, 2),
            );
        }
        echo json_encode((isset($list['data']) ? $list : array('data' => array())));
    }

    public function fetchSuppliersPaymentData(Request $request)
    {
        if (!Permissions::getRolePermissions('suppliersReport')) {
            abort(403, 'Unauthorized action.');
        }
        $payment = new Payments();
        if (isset($request->supplierId) && $request->supplierId != '0') {
            $payment = $payment->whereHas('po', function ($query) use ($request) {
                $query->where('supplier', [$request->supplierId]);
            });
        }
        if ((isset($request->payFrom) && $request->payFrom != '') && (isset($request->payTo) && $request->payTo != '')) {
            $payment = $payment->whereBetween('created_at', array($request->payFrom, $request->payTo));
        }
//        echo $foo_sql = $payment->toSql();

        $filteredData = $payment->get();

        $list = array();
        foreach ($filteredData as $key => $payment) {
            $list['data'][$key] = array(
                'date' => $payment->date,
                'payReference' => $payment->reference_code,
                'purReference' => $payment->parent_reference_code,
                'paidBy' => $payment->pay_type,
                'amount' => number_format($payment->value, 2),
            );
        }
        echo json_encode((isset($list['data']) ? $list : array('data' => array())));
    }
}
