<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\StockMovement;
use App\Exports\SalesReportExport;
use App\Exports\InventoryReportExport;
use App\Exports\FinancialReportExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ReportsController extends Controller
{
    /**
     * Display reports dashboard
     */
    public function index()
    {
        // Quick stats for the dashboard
        $stats = [
            'today_sales' => Sale::whereDate('sale_date', today())->sum('total_amount'),
            'today_orders' => Order::whereDate('created_at', today())->sum('total_amount'),
            'month_sales' => Sale::whereMonth('sale_date', now()->month)->sum('total_amount'),
            'month_orders' => Order::whereMonth('created_at', now()->month)->sum('total_amount'),
            'total_products' => Product::count(),
            'low_stock_products' => Product::whereColumn('quantity_in_stock', '<=', 'reorder_level')->count(),
        ];

        return view('admin.reports.index', compact('stats'));
    }

    /**
     * Sales Report
     */
    public function sales(Request $request)
    {
        $request->validate([
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
            'period' => 'nullable|in:today,week,month,year,custom',
        ]);

        // Determine date range
        $period = $request->get('period', 'month');
        $fromDate = $request->from_date;
        $toDate = $request->to_date;

        switch ($period) {
            case 'today':
                $fromDate = today();
                $toDate = today();
                break;
            case 'week':
                $fromDate = now()->startOfWeek();
                $toDate = now()->endOfWeek();
                break;
            case 'month':
                $fromDate = now()->startOfMonth();
                $toDate = now()->endOfMonth();
                break;
            case 'year':
                $fromDate = now()->startOfYear();
                $toDate = now()->endOfYear();
                break;
        }

        // POS Sales
        $posQuery = Sale::query();
        if ($fromDate) {
            $posQuery->whereDate('sale_date', '>=', $fromDate);
        }
        if ($toDate) {
            $posQuery->whereDate('sale_date', '<=', $toDate);
        }
        
        $posSales = $posQuery->with(['user', 'saleItems'])->orderBy('sale_date', 'desc')->get();
        $posTotalRevenue = $posSales->sum('total_amount');
        $posTotalTransactions = $posSales->count();
        $posTotalItems = $posSales->sum(function($sale) {
            return $sale->saleItems->sum('quantity');
        });

        // Customer Orders
        $ordersQuery = Order::query();
        if ($fromDate) {
            $ordersQuery->whereDate('created_at', '>=', $fromDate);
        }
        if ($toDate) {
            $ordersQuery->whereDate('created_at', '<=', $toDate);
        }
        
        $customerOrders = $ordersQuery->with(['user', 'orderItems'])->orderBy('created_at', 'desc')->get();
        $ordersTotalRevenue = $customerOrders->sum('total_amount');
        $ordersTotalTransactions = $customerOrders->count();
        $ordersTotalItems = $customerOrders->sum(function($order) {
            return $order->orderItems->sum('quantity');
        });

        // Combined Stats
        $totalRevenue = $posTotalRevenue + $ordersTotalRevenue;
        $totalTransactions = $posTotalTransactions + $ordersTotalTransactions;
        $totalItems = $posTotalItems + $ordersTotalItems;
        $averageTransaction = $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0;

        // Sales by Payment Method (POS only)
        $salesByPayment = Sale::select('payment_method', DB::raw('COUNT(*) as count'), DB::raw('SUM(total_amount) as total'))
            ->when($fromDate, function($q) use ($fromDate) {
                return $q->whereDate('sale_date', '>=', $fromDate);
            })
            ->when($toDate, function($q) use ($toDate) {
                return $q->whereDate('sale_date', '<=', $toDate);
            })
            ->groupBy('payment_method')
            ->get();

        // Top Selling Products
        $topProducts = DB::table('sale_items')
            ->select('sale_items.product_name', DB::raw('SUM(sale_items.quantity) as total_quantity'), DB::raw('SUM(sale_items.subtotal) as total_revenue'))
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->when($fromDate, function($q) use ($fromDate) {
                return $q->whereDate('sales.sale_date', '>=', $fromDate);
            })
            ->when($toDate, function($q) use ($toDate) {
                return $q->whereDate('sales.sale_date', '<=', $toDate);
            })
            ->groupBy('sale_items.product_name')
            ->orderBy('total_quantity', 'desc')
            ->limit(10)
            ->get();

        // Sales by Cashier
        $salesByCashier = Sale::select('user_id', DB::raw('COUNT(*) as transactions'), DB::raw('SUM(total_amount) as total'))
            ->with('user')
            ->when($fromDate, function($q) use ($fromDate) {
                return $q->whereDate('sale_date', '>=', $fromDate);
            })
            ->when($toDate, function($q) use ($toDate) {
                return $q->whereDate('sale_date', '<=', $toDate);
            })
            ->groupBy('user_id')
            ->orderBy('total', 'desc')
            ->get();

        return view('admin.reports.sales', compact(
            'posSales',
            'customerOrders',
            'totalRevenue',
            'totalTransactions',
            'totalItems',
            'averageTransaction',
            'posTotalRevenue',
            'ordersTotalRevenue',
            'salesByPayment',
            'topProducts',
            'salesByCashier',
            'period',
            'fromDate',
            'toDate'
        ));
    }

    /**
     * Inventory Report
     */
    public function inventory(Request $request)
    {
        $filter = $request->get('filter', 'all');

        $query = Product::with(['category', 'brand']);

        switch ($filter) {
            case 'low_stock':
                $query->whereColumn('quantity_in_stock', '<=', 'reorder_level');
                break;
            case 'out_of_stock':
                $query->where('quantity_in_stock', 0);
                break;
            case 'overstocked':
                $query->whereColumn('quantity_in_stock', '>', DB::raw('reorder_level * 3'));
                break;
        }

        $products = $query->orderBy('quantity_in_stock', 'asc')->get();

        // Inventory Summary
        $totalProducts = Product::count();
        $totalValue = Product::sum(DB::raw('quantity_in_stock * cost_price'));
        $lowStockCount = Product::whereColumn('quantity_in_stock', '<=', 'reorder_level')->count();
        $outOfStockCount = Product::where('quantity_in_stock', 0)->count();

        // Stock Movements (Last 30 days)
        $stockMovements = StockMovement::with(['product', 'user'])
            ->whereDate('created_at', '>=', now()->subDays(30))
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        // Products by Category
        $productsByCategory = Product::select('category_id', DB::raw('COUNT(*) as count'), DB::raw('SUM(quantity_in_stock) as total_stock'))
            ->with('category')
            ->groupBy('category_id')
            ->get();

        return view('admin.reports.inventory', compact(
            'products',
            'totalProducts',
            'totalValue',
            'lowStockCount',
            'outOfStockCount',
            'stockMovements',
            'productsByCategory',
            'filter'
        ));
    }

    /**
     * Financial Report
     */
    public function financial(Request $request)
    {
        $request->validate([
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
        ]);

        $fromDate = $request->get('from_date', now()->startOfMonth()->toDateString());
        $toDate = $request->get('to_date', now()->endOfMonth()->toDateString());

        // Revenue
        $posRevenue = Sale::whereDate('sale_date', '>=', $fromDate)
            ->whereDate('sale_date', '<=', $toDate)
            ->sum('total_amount');

        $orderRevenue = Order::whereDate('created_at', '>=', $fromDate)
            ->whereDate('created_at', '<=', $toDate)
            ->whereIn('status', ['completed'])
            ->sum('total_amount');

        $totalRevenue = $posRevenue + $orderRevenue;

        // Tax Collected
        $posTax = Sale::whereDate('sale_date', '>=', $fromDate)
            ->whereDate('sale_date', '<=', $toDate)
            ->sum('tax_amount');

        $orderTax = Order::whereDate('created_at', '>=', $fromDate)
            ->whereDate('created_at', '<=', $toDate)
            ->sum('tax');

        $totalTax = $posTax + $orderTax;

        // Cost of Goods Sold (COGS)
        $cogsSales = DB::table('sale_items')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->whereDate('sales.sale_date', '>=', $fromDate)
            ->whereDate('sales.sale_date', '<=', $toDate)
            ->select(DB::raw('SUM(sale_items.quantity * products.cost_price) as total_cogs'))
            ->value('total_cogs') ?? 0;

        $cogsOrders = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereDate('orders.created_at', '>=', $fromDate)
            ->whereDate('orders.created_at', '<=', $toDate)
            ->where('orders.status', 'completed')
            ->select(DB::raw('SUM(order_items.quantity * products.cost_price) as total_cogs'))
            ->value('total_cogs') ?? 0;

        $totalCOGS = $cogsSales + $cogsOrders;

        // Gross Profit
        $grossProfit = $totalRevenue - $totalCOGS;
        $grossProfitMargin = $totalRevenue > 0 ? ($grossProfit / $totalRevenue) * 100 : 0;

        // Daily Revenue Chart Data
        $dailyRevenue = [];
        $period = Carbon::parse($fromDate)->daysUntil(Carbon::parse($toDate));
        
        foreach ($period as $date) {
            $dayPos = Sale::whereDate('sale_date', $date)->sum('total_amount');
            $dayOrders = Order::whereDate('created_at', $date)->whereIn('status', ['completed'])->sum('total_amount');
            
            $dailyRevenue[] = [
                'date' => $date->format('M d'),
                'amount' => $dayPos + $dayOrders,
            ];
        }

        return view('admin.reports.financial', compact(
            'totalRevenue',
            'posRevenue',
            'orderRevenue',
            'totalTax',
            'totalCOGS',
            'grossProfit',
            'grossProfitMargin',
            'dailyRevenue',
            'fromDate',
            'toDate'
        ));
    }

    /**
     * Export Sales Report to Excel
     */
    public function exportSales(Request $request)
    {
        $request->validate([
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
            'period' => 'nullable|in:today,week,month,year,custom',
        ]);

        // Determine date range
        $period = $request->get('period', 'month');
        $fromDate = $request->from_date;
        $toDate = $request->to_date;

        switch ($period) {
            case 'today':
                $fromDate = today();
                $toDate = today();
                break;
            case 'week':
                $fromDate = now()->startOfWeek();
                $toDate = now()->endOfWeek();
                break;
            case 'month':
                $fromDate = now()->startOfMonth();
                $toDate = now()->endOfMonth();
                break;
            case 'year':
                $fromDate = now()->startOfYear();
                $toDate = now()->endOfYear();
                break;
        }

        // Get data
        $posQuery = Sale::query();
        if ($fromDate) {
            $posQuery->whereDate('sale_date', '>=', $fromDate);
        }
        if ($toDate) {
            $posQuery->whereDate('sale_date', '<=', $toDate);
        }
        $posSales = $posQuery->with(['user', 'saleItems'])->orderBy('sale_date', 'desc')->get();

        $ordersQuery = Order::query();
        if ($fromDate) {
            $ordersQuery->whereDate('created_at', '>=', $fromDate);
        }
        if ($toDate) {
            $ordersQuery->whereDate('created_at', '<=', $toDate);
        }
        $customerOrders = $ordersQuery->with(['user', 'orderItems'])->orderBy('created_at', 'desc')->get();

        $summary = [
            'totalRevenue' => $posSales->sum('total_amount') + $customerOrders->sum('total_amount'),
            'totalTransactions' => $posSales->count() + $customerOrders->count(),
        ];

        $filename = 'sales_report_' . now()->format('Y-m-d_His') . '.xlsx';
        return Excel::download(new SalesReportExport($posSales, $customerOrders, $summary), $filename);
    }

    /**
     * Export Inventory Report to Excel
     */
    public function exportInventory(Request $request)
    {
        $filter = $request->get('filter', 'all');

        $query = Product::with(['category', 'brand']);

        switch ($filter) {
            case 'low_stock':
                $query->whereColumn('quantity_in_stock', '<=', 'reorder_level');
                break;
            case 'out_of_stock':
                $query->where('quantity_in_stock', 0);
                break;
            case 'overstocked':
                $query->whereColumn('quantity_in_stock', '>', DB::raw('reorder_level * 3'));
                break;
        }

        $products = $query->orderBy('quantity_in_stock', 'asc')->get();

        $filename = 'inventory_report_' . now()->format('Y-m-d_His') . '.xlsx';
        return Excel::download(new InventoryReportExport($products), $filename);
    }

    /**
     * Export Financial Report to Excel
     */
    public function exportFinancial(Request $request)
    {
        $request->validate([
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
        ]);

        $fromDate = $request->get('from_date', now()->startOfMonth()->toDateString());
        $toDate = $request->get('to_date', now()->endOfMonth()->toDateString());

        // Revenue
        $posRevenue = Sale::whereDate('sale_date', '>=', $fromDate)
            ->whereDate('sale_date', '<=', $toDate)
            ->sum('total_amount');

        $orderRevenue = Order::whereDate('created_at', '>=', $fromDate)
            ->whereDate('created_at', '<=', $toDate)
            ->whereIn('status', ['completed'])
            ->sum('total_amount');

        $totalRevenue = $posRevenue + $orderRevenue;

        // Tax Collected
        $posTax = Sale::whereDate('sale_date', '>=', $fromDate)
            ->whereDate('sale_date', '<=', $toDate)
            ->sum('tax_amount');

        $orderTax = Order::whereDate('created_at', '>=', $fromDate)
            ->whereDate('created_at', '<=', $toDate)
            ->sum('tax');

        $totalTax = $posTax + $orderTax;

        // Cost of Goods Sold (COGS)
        $cogsSales = DB::table('sale_items')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->whereDate('sales.sale_date', '>=', $fromDate)
            ->whereDate('sales.sale_date', '<=', $toDate)
            ->select(DB::raw('SUM(sale_items.quantity * products.cost_price) as total_cogs'))
            ->value('total_cogs') ?? 0;

        $cogsOrders = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereDate('orders.created_at', '>=', $fromDate)
            ->whereDate('orders.created_at', '<=', $toDate)
            ->where('orders.status', 'completed')
            ->select(DB::raw('SUM(order_items.quantity * products.cost_price) as total_cogs'))
            ->value('total_cogs') ?? 0;

        $totalCOGS = $cogsSales + $cogsOrders;

        // Gross Profit
        $grossProfit = $totalRevenue - $totalCOGS;
        $grossProfitMargin = $totalRevenue > 0 ? ($grossProfit / $totalRevenue) * 100 : 0;

        // Daily Revenue Chart Data
        $dailyRevenue = [];
        $period = Carbon::parse($fromDate)->daysUntil(Carbon::parse($toDate));
        
        foreach ($period as $date) {
            $dayPos = Sale::whereDate('sale_date', $date)->sum('total_amount');
            $dayOrders = Order::whereDate('created_at', $date)->whereIn('status', ['completed'])->sum('total_amount');
            
            $dailyRevenue[] = [
                'date' => $date->format('M d'),
                'amount' => $dayPos + $dayOrders,
            ];
        }

        $summary = [
            'totalRevenue' => $totalRevenue,
            'posRevenue' => $posRevenue,
            'orderRevenue' => $orderRevenue,
            'totalTax' => $totalTax,
            'totalCOGS' => $totalCOGS,
            'grossProfit' => $grossProfit,
            'grossProfitMargin' => $grossProfitMargin,
        ];

        $filename = 'financial_report_' . now()->format('Y-m-d_His') . '.xlsx';
        return Excel::download(new FinancialReportExport($summary, $dailyRevenue, $fromDate, $toDate), $filename);
    }
}
