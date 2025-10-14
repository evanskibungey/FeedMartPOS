<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PurchaseOrderController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\POS\POSDashboardController;
use App\Http\Controllers\POS\POSLoginController;
use App\Http\Controllers\POS\SaleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Customer Portal Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Shop Routes (public access)
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/products/{id}', [ShopController::class, 'show'])->name('shop.show');

// Cart Routes (public access for adding, auth required for checkout)
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

// Customer Dashboard (requires authentication and customer role)
Route::middleware(['auth', 'customer'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Order Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});

/*
|--------------------------------------------------------------------------
| Admin Portal Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    
    // Admin Authentication Routes (guest only)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'create'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'store']);
    });

    // Admin Protected Routes (requires authentication and admin role)
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AdminLoginController::class, 'destroy'])->name('logout');

        // User Management Routes
        Route::resource('users', UserManagementController::class);
        Route::post('users/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])
            ->name('users.toggle-status');
        Route::post('users/{user}/update-password', [UserManagementController::class, 'updatePassword'])
            ->name('users.update-password');

        // Category Management Routes
        Route::resource('categories', CategoryController::class);
        Route::post('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])
            ->name('categories.toggle-status');

        // Brand Management Routes
        Route::resource('brands', BrandController::class);
        Route::post('brands/{brand}/toggle-status', [BrandController::class, 'toggleStatus'])
            ->name('brands.toggle-status');

        // Supplier Management Routes
        Route::resource('suppliers', SupplierController::class);
        Route::post('suppliers/{supplier}/toggle-status', [SupplierController::class, 'toggleStatus'])
            ->name('suppliers.toggle-status');

        // Product Management Routes
        Route::resource('products', ProductController::class);
        Route::post('products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])
            ->name('products.toggle-status');

        // Purchase Order Routes
        Route::resource('purchase-orders', PurchaseOrderController::class);
        Route::get('purchase-orders-drafts', [PurchaseOrderController::class, 'drafts'])->name('purchase-orders.drafts');
        Route::post('purchase-orders/{purchase_order}/mark-ordered', [PurchaseOrderController::class, 'markAsOrdered'])
            ->name('purchase-orders.mark-ordered');
        Route::post('purchase-orders/{purchase_order}/receive', [PurchaseOrderController::class, 'receive'])
            ->name('purchase-orders.receive');
        Route::post('purchase-orders/{purchase_order}/cancel', [PurchaseOrderController::class, 'cancel'])
            ->name('purchase-orders.cancel');

        // Inventory Routes
        Route::prefix('inventory')->name('inventory.')->group(function () {
            Route::get('/', [InventoryController::class, 'index'])->name('index');
            Route::get('/movements', [InventoryController::class, 'movements'])->name('movements');
            Route::get('/low-stock', [InventoryController::class, 'lowStock'])->name('low-stock');
            Route::get('/reorder-report', [InventoryController::class, 'reorderReport'])->name('reorder');
            Route::get('/adjust', [InventoryController::class, 'adjustStock'])->name('adjust');
            Route::post('/adjust', [InventoryController::class, 'processAdjustment'])->name('adjust.store');
        });

        // Customer Management Routes
        Route::resource('customers', CustomerController::class);
        Route::post('customers/{customer}/toggle-status', [CustomerController::class, 'toggleStatus'])
            ->name('customers.toggle-status');
        Route::post('customers/{customer}/update-password', [CustomerController::class, 'updatePassword'])
            ->name('customers.update-password');

        // Settings Routes
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings/system', [SettingsController::class, 'updateSystem'])->name('settings.update-system');
        Route::post('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.update-profile');
        Route::post('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.update-password');
        Route::delete('/settings/logo', [SettingsController::class, 'removeLogo'])->name('settings.remove-logo');
    });
});

/*
|--------------------------------------------------------------------------
| POS Portal Routes
|--------------------------------------------------------------------------
*/

Route::prefix('pos')->name('pos.')->group(function () {
    
    // POS Authentication Routes (guest only)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [POSLoginController::class, 'create'])->name('login');
        Route::post('/login', [POSLoginController::class, 'store']);
    });

    // POS Protected Routes (requires authentication and pos role)
    Route::middleware(['auth', 'pos'])->group(function () {
        Route::get('/dashboard', [POSDashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [POSLoginController::class, 'destroy'])->name('logout');
        
        // Product API Routes
        Route::get('/products/{id}', [POSDashboardController::class, 'getProduct'])->name('products.show');
        
        // Sale Routes
        Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
        Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
        Route::get('/sales/{sale}', [SaleController::class, 'show'])->name('sales.show');
        Route::get('/sales/today/stats', [SaleController::class, 'todayStats'])->name('sales.today-stats');
    });
});

// Include customer authentication routes (register, login, password reset)
require __DIR__.'/auth.php';
