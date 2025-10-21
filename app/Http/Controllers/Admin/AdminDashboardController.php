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
use Illuminate\Support\Facades\Cache;

class AdminDashboardController extends Controller
{
    /**
     * Display admin dashboard with real-time statistics
     */
    public function index()
    {
        // Cache statistics for 5 minutes to reduce database load
        $cacheKey = 'admin_dashboard_stats_' . now()->format('YmdHi');
        $cacheDuration = now()->addMinutes(5);

        $stats = Cache::remember($cacheKey, $cacheDuration, function () {
            return [
                'userStats' => $this->getUserStats(),
                'productStats' => $this->getProductStats(),
                'orderStats' => $this->getOrderStats(),
                'salesStats' => $this->getSalesStats(),
                'revenueStats' => $this->getRevenueStats(),
            ];
        });

        // Real-time data (not cached)
        $recentActivity = $this->getRecentActivity();
        $topProducts = $this->getTopProducts();
        $weeklyRevenue = $this->getWeeklyRevenue();
        $stockAlerts = $this->getStockAlerts();
        $paymentMethods = $this->getPaymentMethodsBreakdown();
        $monthComparison = $this->getMonthComparison();

        return view('admin.dashboard', array_merge($stats, compact(
            'recentActivity',
            'topProducts',
            'weeklyRevenue',
            'stockAlerts',
            'paymentMethods',
            'monthComparison'
        )));
    }

    /**
     * Get user statistics (optimized)
     */
    private function getUserStats(): array
    {
        // Single query to get all user stats
        $stats = User::selectRaw('
            COUNT(*) as total_users,
            SUM(CASE WHEN role = "customer" THEN 1 ELSE 0 END) as total_customers,
            SUM(CASE WHEN role IN ("admin", "cashier", "super_admin") THEN 1 ELSE 0 END) as total_staff,
            SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active_users
        ')->first();

        return [
            'total_users' => $stats->total_users ?? 0,
            'total_customers' => $stats->total_customers ?? 0,
            'total_staff' => $stats->total_staff ?? 0,
            'active_users' => $stats->active_users ?? 0,
        ];
    }

    /**
     * Get product statistics (optimized)
     */
    private function getProductStats(): array
    {
        // Single query for product stats
        $stats = Product::selectRaw('
            COUNT(*) as total_products,
            SUM(CASE WHEN status = "active" THEN 1 ELSE 0 END) as active_products,
            SUM(CASE WHEN quantity_in_stock <= reorder_level AND quantity_in_stock > 0 THEN 1 ELSE 0 END) as low_stock,
            SUM(CASE WHEN quantity_in_stock <= 0 THEN 1 ELSE 0 END) as out_of_stock
        ')->first();

        return [
            'total_products' => $stats->total_products ?? 0,
            'active_products' => $stats->active_products ?? 0,
            'low_stock_products' => $stats->low_stock ?? 0,
            'out_of_stock_products' => $stats->out_of_stock ?? 0,
            'total_categories' => Category::count(),
            'total_brands' => Brand::count(),
        ];
    }

    /**
     * Get order statistics (optimized)
     */
    private function getOrderStats(): array
    {
        $today = today();
        
        // Single query for all order stats
        $stats = Order::selectRaw('
            COUNT(*) as total_orders,
            SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending,
            SUM(CASE WHEN status = "processing" THEN 1 ELSE 0 END) as processing,
            SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed,
            SUM(CASE WHEN status = "cancelled" THEN 1 ELSE 0 END) as cancelled,
            SUM(CASE WHEN status = "completed" THEN total_amount ELSE 0 END) as total_revenue,
            SUM(CASE WHEN DATE(created_at) = ? THEN 1 ELSE 0 END) as today_count,
            SUM(CASE WHEN DATE(created_at) = ? THEN total_amount ELSE 0 END) as today_revenue
        ', [$today, $today])->first();

        return [
            'total_orders' => $stats->total_orders ?? 0,
            'pending_orders' => $stats->pending ?? 0,
            'processing_orders' => $stats->processing ?? 0,
            'completed_orders' => $stats->completed ?? 0,
            'cancelled_orders' => $stats->cancelled ?? 0,
            'total_order_revenue' => $stats->total_revenue ?? 0,
            'today_orders' => $stats->today_count ?? 0,
            'today_order_revenue' => $stats->today_revenue ?? 0,
        ];
    }

    /**
     * Get sales statistics (optimized)
     */
    private function getSalesStats(): array
    {
        $today = today();
        
        // Single query for all sales stats
        $stats = Sale::selectRaw('
            SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as total_sales,
            SUM(CASE WHEN status = "completed" THEN total_amount ELSE 0 END) as total_revenue,
            SUM(CASE WHEN DATE(sale_date) = ? AND status = "completed" THEN 1 ELSE 0 END) as today_count,
            SUM(CASE WHEN DATE(sale_date) = ? AND status = "completed" THEN total_amount ELSE 0 END) as today_revenue
        ', [$today, $today])->first();

        return [
            'total_sales' => $stats->total_sales ?? 0,
            'total_sales_revenue' => $stats->total_revenue ?? 0,
            'today_sales' => $stats->today_count ?? 0,
            'today_sales_revenue' => $stats->today_revenue ?? 0,
        ];
    }

    /**
     * Calculate combined revenue stats
     */
    private function getRevenueStats(): array
    {
        $orderStats = $this->getOrderStats();
        $salesStats = $this->getSalesStats();

        return [
            'total_revenue' => $orderStats['total_order_revenue'] + $salesStats['total_sales_revenue'],
            'today_revenue' => $orderStats['today_order_revenue'] + $salesStats['today_sales_revenue'],
            'total_transactions' => $orderStats['total_orders'] + $salesStats['total_sales'],
            'today_transactions' => $orderStats['today_orders'] + $salesStats['today_sales'],
        ];
    }

    /**
     * Get recent activity (optimized)
     */
    private function getRecentActivity()
    {
        // Optimize by selecting only needed columns
        $recentOrders = Order::select('id', 'order_number', 'user_id', 'total_amount', 'status', 'created_at')
            ->with('user:id,name')
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

        $recentSales = Sale::select('id', 'receipt_number', 'user_id', 'customer_name', 'total_amount', 'status', 'sale_date')
            ->with('user:id,name')
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

        return $recentOrders->concat($recentSales)
            ->sortByDesc('date')
            ->take(10);
    }

    /**
     * Get top selling products (cached for 30 minutes)
     */
    private function getTopProducts()
    {
        return Cache::remember('dashboard_top_products', now()->addMinutes(30), function () {
            return DB::table('sale_items')
                ->join('products', 'sale_items.product_id', '=', 'products.id')
                ->select(
                    'products.id',
                    'products.name',
                    'products.image',
                    DB::raw('SUM(sale_items.quantity) as total_sold')
                )
                ->groupBy('products.id', 'products.name', 'products.image')
                ->orderByDesc('total_sold')
                ->limit(5)
                ->get();
        });
    }

    /**
     * Get weekly revenue trend (optimized - single query)
     */
    private function getWeeklyRevenue()
    {
        $dates = collect(range(6, 0))->map(fn($i) => now()->subDays($i)->toDateString());
        
        // Single query for orders
        $orderRevenue = Order::selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue')
            ->whereIn(DB::raw('DATE(created_at)'), $dates)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->pluck('revenue', 'date');

        // Single query for sales
        $salesRevenue = Sale::selectRaw('DATE(sale_date) as date, SUM(total_amount) as revenue')
            ->whereIn(DB::raw('DATE(sale_date)'), $dates)
            ->groupBy(DB::raw('DATE(sale_date)'))
            ->pluck('revenue', 'date');

        // Combine results
        return $dates->map(function ($date) use ($orderRevenue, $salesRevenue) {
            $dateObj = \Carbon\Carbon::parse($date);
            return [
                'date' => $dateObj->format('D'),
                'full_date' => $dateObj->format('M d'),
                'revenue' => ($orderRevenue[$date] ?? 0) + ($salesRevenue[$date] ?? 0),
            ];
        });
    }

    /**
     * Get stock alerts (optimized)
     */
    private function getStockAlerts(): array
    {
        return [
            'low_stock' => Product::select('id', 'name', 'sku', 'quantity_in_stock', 'reorder_level', 'category_id')
                ->with('category:id,name')
                ->lowStock()
                ->limit(5)
                ->get(),
            'out_of_stock' => Product::select('id', 'name', 'sku', 'quantity_in_stock', 'category_id')
                ->with('category:id,name')
                ->outOfStock()
                ->limit(5)
                ->get(),
        ];
    }

    /**
     * Get payment methods breakdown (cached)
     */
    private function getPaymentMethodsBreakdown()
    {
        return Cache::remember('dashboard_payment_methods', now()->addMinutes(15), function () {
            return Sale::where('status', 'completed')
                ->select('payment_method', DB::raw('COUNT(*) as count'), DB::raw('SUM(total_amount) as total'))
                ->groupBy('payment_method')
                ->get();
        });
    }

    /**
     * Get month comparison (optimized)
     */
    private function getMonthComparison(): array
    {
        $currentMonth = now();
        $lastMonth = now()->subMonth();

        // Single combined query for current month
        $currentRevenue = DB::selectOne('
            SELECT 
                COALESCE(SUM(CASE WHEN source = "orders" THEN total END), 0) + 
                COALESCE(SUM(CASE WHEN source = "sales" THEN total END), 0) as revenue
            FROM (
                SELECT "orders" as source, SUM(total_amount) as total
                FROM orders
                WHERE MONTH(created_at) = ? AND YEAR(created_at) = ?
                UNION ALL
                SELECT "sales" as source, SUM(total_amount) as total
                FROM sales
                WHERE MONTH(sale_date) = ? AND YEAR(sale_date) = ?
            ) combined
        ', [
            $currentMonth->month, $currentMonth->year,
            $currentMonth->month, $currentMonth->year
        ]);

        // Single combined query for last month
        $lastRevenue = DB::selectOne('
            SELECT 
                COALESCE(SUM(CASE WHEN source = "orders" THEN total END), 0) + 
                COALESCE(SUM(CASE WHEN source = "sales" THEN total END), 0) as revenue
            FROM (
                SELECT "orders" as source, SUM(total_amount) as total
                FROM orders
                WHERE MONTH(created_at) = ? AND YEAR(created_at) = ?
                UNION ALL
                SELECT "sales" as source, SUM(total_amount) as total
                FROM sales
                WHERE MONTH(sale_date) = ? AND YEAR(sale_date) = ?
            ) combined
        ', [
            $lastMonth->month, $lastMonth->year,
            $lastMonth->month, $lastMonth->year
        ]);

        $currentMonthRevenue = $currentRevenue->revenue ?? 0;
        $lastMonthRevenue = $lastRevenue->revenue ?? 0;

        return [
            'current_month' => $currentMonthRevenue,
            'last_month' => $lastMonthRevenue,
            'growth_percentage' => $lastMonthRevenue > 0 
                ? (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 
                : 0,
        ];
    }
}
