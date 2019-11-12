<?php

namespace App\Http\Controllers;

use App\Adjustment;
use App\Brands;
use App\Categories;
use App\Invoice;
use App\Locations;
use App\PO;
use App\Products;
use App\Stock;
use App\Transfers;
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

        return view('vendor.adminlte.reports.categoriesReport.index');

    }

    public function fetchCategoryData(Request $request)
    {


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

        return view('vendor.adminlte.reports.brandsReport.index');
    }

    public function fetchBrandsData(Request $request)
    {


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
        $adjustments = Adjustment::groupBy('created_by')->get();
        $locations = Locations::all();

        return view('vendor.adminlte.reports.adjustmentReport.index', ['adjustUsers' => $adjustments, 'warehouses' => $locations]);
    }

    public function adjustmentData(Request $request)
    {
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
        $yearMonth = date('Y-m');
        $table = $this->dratTable(date('m'), date('Y'));

        return view('vendor.adminlte.reports.dailySalesReport.index', ['table' => $table, 'yearMonth' => $yearMonth]);
    }

    public function dailySalesForMonth(Request $request)
    {
        $parts = explode('-', $request['month']);
        return json_encode($this->dratTable($parts[1], $parts[0]));
    }

    public function dratTable($month, $year)
    {
        /* draw table */
        $calendar = '<table id="manageTable" cellpadding="0" cellspacing="0" class="table table-bordered calendar">';

        /* table headings */
        $headings = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
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

            /** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
            $calendar .= str_repeat('<p>' . $this->dayToDrawSummary($list_day, $month, $year) . '</p>', 1);

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

    public function monthlySalesIndex()
    {
        $yearMonth = date('Y');
        $table = $this->drawMonthTable(date('Y'));

        return view('vendor.adminlte.reports.monthlySalesReport.index', ['table' => $table, 'yearMonth' => $yearMonth]);
    }

    public function monthlySalesForMonth(Request $request)
    {
//        $parts = explode('-', $request['month']);
        return json_encode($this->drawMonthTable($request['year']));
    }

    public function drawMonthTable($year)
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
            $calendar .= '<td class="calendar-day-np">';
            $calendar .= str_repeat('<p>' . $this->monthToDrawSummary($x, $year) . '</p>', 1);
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

    public function last5Sales()
    {
        $invoices = Invoice::latest()->limit(5)->get();
        $array = [];
        foreach ($invoices as $key => $invoice) {
            $array[$key]['invoice_date'] = $invoice->invoice_date;
            $array[$key]['invoice_code'] = $invoice->invoice_code;
            $array[$key]['cus_name'] = $invoice->customers->name;
            $array[$key]['sales_status'] = $invoice->sales_status;
            $array[$key]['invoice_grand_total'] = number_format($invoice->invoice_grand_total,2);
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
            $array[$key]['date'] = $po->due_date;
            $array[$key]['referenceCode'] = $po->referenceCode;
            $array[$key]['sup_name'] = $po->suppliers->name;
            $array[$key]['status'] = $po->sales_status;
            $array[$key]['grand_total'] = number_format($po->grand_total,2);
        }
        return $array;
    }

    public function last5Transfers()
    {
        $pos = Transfers::latest()->limit(5)->get();
        $array = [];
        foreach ($pos as $key => $po) {
            $array[$key]['date'] = $po->due_date;
            $array[$key]['referenceCode'] = $po->referenceCode;
            $array[$key]['sup_name'] = $po->suppliers->name;
            $array[$key]['status'] = $po->sales_status;
            $array[$key]['grand_total'] = number_format($po->grand_total,2);
        }
        return $array;
    }

    public function last5Customers()
    {

    }

    public function last5Suppliers()
    {

    }
}
