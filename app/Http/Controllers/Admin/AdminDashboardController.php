<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Sale;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Display admin dashboard with real-time statistics
     */
    public function index()
    {
        // User Statistics
        $userStats = [
            'total_users' => User::count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'total_staff' => User::whereIn('role', ['admin', 'cashier', 'super_admin'])->count(),
            'active_users' => User::where('is_active', true)->count(),
        ];

        // Product Statistics
        $productStats = [
            'total_products' => Product::count(),
            'active_products' => Product::active()->count(),
            'low_stock_products' => Product::lowStock()->count(),
            'out_of_stock_products' => Product::outOfStock()->count(),
            'total_categories' => Category::count(),
            'total_brands' => Brand::count(),
        ];

        // Order Statistics (Customer Orders)
        $orderStats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::pending()->count(),
            'processing_orders' => Order::processing()->count(),
            'completed_orders' => Order::completed()->count(),
            'cancelled_orders' => Order::cancelled()->count(),
            'total_order_revenue' => Order::completed()->sum('total_amount'),
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'today_order_revenue' => Order::whereDate('created_at', today())->sum('total_amount'),
        ];

        // POS Sales Statistics
        $salesStats = [
            'total_sales' => Sale::completed()->count(),
            'total_sales_revenue' => Sale::completed()->sum('total_amount'),
            'today_sales' => Sale::today()->completed()->count(),
            'today_sales_revenue' => Sale::today()->completed()->sum('total_amount'),
        ];

        // Combined Revenue Statistics
        $revenueStats = [
            'total_revenue' => $orderStats['total_order_revenue'] + $salesStats['total_sales_revenue'],
            'today_revenue' => $orderStats['today_order_revenue'] + $salesStats['today_sales_revenue'],
            'total_transactions' => $orderStats['total_orders'] + $salesStats['total_sales'],
            'today_transactions' => $orderStats['today_orders'] + $salesStats['today_sales'],
        ];

        // Recent Activity (Last 5 orders and sales combined)
        $recentOrders = Order::with('user')
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($order) {
                return [
                    'type' => 'order',
                    'id' => $order->id,
                    'number' => $order->order_number,
                    'customer' => $order->user->name ?? 'Guest',
                    'amount' => $order->total_amount,
                    'status' => $order->status,
                    'date' => $order->created_at,
                ];
            });

        $recentSales = Sale::with('user')
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($sale) {
                return [
                    'type' => 'sale',
                    'id' => $sale->id,
                    'number' => $sale->receipt_number,
                    'customer' => $sale->customer_name ?: 'Walk-in',
                    'cashier' => $sale->user->name ?? 'Unknown',
                    'amount' => $sale->total_amount,
                    'status' => $sale->status,
                    'date' => $sale->sale_date,
                ];
            });

        $recentActivity = $recentOrders->concat($recentSales)
            ->sortByDesc('date')
            ->take(10);

        // Top Selling Products (based on sales quantity)
        $topProducts = DB::table('sale_items')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->select('products.id', 'products.name', 'products.image', DB::raw('SUM(sale_items.quantity) as total_sold'))
            ->groupBy('products.id', 'products.name', 'products.image')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // Weekly Revenue Trend (Last 7 days)
        $weeklyRevenue = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dayOrders = Order::whereDate('created_at', $date->toDateString())->sum('total_amount');
            $daySales = Sale::whereDate('sale_date', $date->toDateString())->sum('total_amount');
            
            $weeklyRevenue[] = [
                'date' => $date->format('D'),
                'full_date' => $date->format('M d'),
                'revenue' => $dayOrders + $daySales,
            ];
        }

        // Stock Alerts - Products needing attention
        $stockAlerts = [
            'low_stock' => Product::lowStock()->with('category')->limit(5)->get(),
            'out_of_stock' => Product::outOfStock()->with('category')->limit(5)->get(),
        ];

        // Payment Methods Breakdown (for POS sales)
        $paymentMethods = Sale::completed()
            ->select('payment_method', DB::raw('COUNT(*) as count'), DB::raw('SUM(total_amount) as total'))
            ->groupBy('payment_method')
            ->get();

        // Month Comparison
        $currentMonth = now();
        $lastMonth = now()->subMonth();
        
        $currentMonthRevenue = Order::whereMonth('created_at', $currentMonth->month)
            ->whereYear('created_at', $currentMonth->year)
            ->sum('total_amount')
            + Sale::whereMonth('sale_date', $currentMonth->month)
            ->whereYear('sale_date', $currentMonth->year)
            ->sum('total_amount');

        $lastMonthRevenue = Order::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->sum('total_amount')
            + Sale::whereMonth('sale_date', $lastMonth->month)
            ->whereYear('sale_date', $lastMonth->year)
            ->sum('total_amount');

        $monthComparison = [
            'current_month' => $currentMonthRevenue,
            'last_month' => $lastMonthRevenue,
            'growth_percentage' => $lastMonthRevenue > 0 
                ? (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 
                : 0,
        ];

        return view('admin.dashboard', compact(
            'userStats',
            'productStats',
            'orderStats',
            'salesStats',
            'revenueStats',
            'recentActivity',
            'topProducts',
            'weeklyRevenue',
            'stockAlerts',
            'paymentMethods',
            'monthComparison'
        ));
    }
}
