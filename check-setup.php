<?php

// Quick database check script
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "=== DATABASE CONNECTION CHECK ===\n\n";

try {
    // Test connection
    DB::connection()->getPdo();
    echo "✅ Database connected successfully!\n";
    echo "Database: " . env('DB_DATABASE') . "\n\n";
    
    echo "=== CHECKING TABLES ===\n\n";
    
    $requiredTables = ['users', 'products', 'categories', 'sales', 'sale_items', 'stock_movements'];
    
    foreach ($requiredTables as $table) {
        if (Schema::hasTable($table)) {
            echo "✅ Table '$table' exists\n";
        } else {
            echo "❌ Table '$table' MISSING\n";
        }
    }
    
    echo "\n=== CHECKING MIGRATIONS STATUS ===\n\n";
    
    $migrations = DB::table('migrations')->get();
    echo "Total migrations run: " . $migrations->count() . "\n\n";
    
    $salesMigrations = $migrations->filter(function($m) {
        return str_contains($m->migration, 'sales') || str_contains($m->migration, 'sale_items');
    });
    
    if ($salesMigrations->count() > 0) {
        echo "✅ Sales migrations have been run:\n";
        foreach ($salesMigrations as $m) {
            echo "  - " . $m->migration . "\n";
        }
    } else {
        echo "❌ Sales migrations have NOT been run yet\n";
        echo "   You need to run: php artisan migrate\n";
    }
    
    echo "\n=== CHECKING MODELS ===\n\n";
    
    $modelFiles = [
        'app/Models/Sale.php',
        'app/Models/SaleItem.php'
    ];
    
    foreach ($modelFiles as $file) {
        if (file_exists(__DIR__ . '/' . $file)) {
            echo "✅ Model file exists: $file\n";
        } else {
            echo "❌ Model file MISSING: $file\n";
        }
    }
    
    echo "\n=== CHECKING CONTROLLER ===\n\n";
    
    if (file_exists(__DIR__ . '/app/Http/Controllers/POS/SaleController.php')) {
        echo "✅ SaleController exists\n";
    } else {
        echo "❌ SaleController MISSING\n";
    }
    
    echo "\n=== CHECKING ROUTES ===\n\n";
    
    $routes = app('router')->getRoutes();
    $salesRoutes = [];
    
    foreach ($routes as $route) {
        if (str_contains($route->uri(), 'pos/sales')) {
            $salesRoutes[] = $route->methods()[0] . ' ' . $route->uri();
        }
    }
    
    if (count($salesRoutes) > 0) {
        echo "✅ Sales routes registered:\n";
        foreach ($salesRoutes as $route) {
            echo "  - $route\n";
        }
    } else {
        echo "❌ No sales routes found\n";
    }
    
} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
}

echo "\n=== DONE ===\n";
