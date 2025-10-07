<?php
// Quick database test script
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Testing FeedMart Database ===\n\n";

// Check categories
echo "Categories in database:\n";
$categories = \App\Models\Category::all();
echo "Count: " . $categories->count() . "\n";
foreach ($categories as $cat) {
    echo "  - {$cat->id}: {$cat->name}\n";
}

echo "\nBrands in database:\n";
$brands = \App\Models\Brand::all();
echo "Count: " . $brands->count() . "\n";
foreach ($brands as $brand) {
    echo "  - {$brand->id}: {$brand->name}\n";
}

echo "\nProducts in database:\n";
$products = \App\Models\Product::with(['category', 'brand'])->get();
echo "Count: " . $products->count() . "\n";
if ($products->count() > 0) {
    foreach ($products->take(10) as $product) {
        $stockStatus = $product->stock_status;
        $statusEmoji = $stockStatus === 'ok' ? '✅' : ($stockStatus === 'low' ? '⚠️' : '❌');
        echo "  {$statusEmoji} {$product->name} - Stock: {$product->quantity_in_stock} {$product->unit} (Reorder: {$product->reorder_level})\n";
        echo "     Category: {$product->category->name} | Brand: {$product->brand->name} | Price: KES " . number_format($product->price, 2) . "\n";
    }
    if ($products->count() > 10) {
        echo "  ... and " . ($products->count() - 10) . " more products\n";
    }
    
    echo "\nStock Summary:\n";
    echo "  - In Stock (OK): " . $products->filter(fn($p) => $p->stock_status === 'ok')->count() . "\n";
    echo "  - Low Stock (⚠️): " . $products->filter(fn($p) => $p->stock_status === 'low')->count() . "\n";
    echo "  - Out of Stock (❌): " . $products->filter(fn($p) => $p->stock_status === 'out')->count() . "\n";
    echo "  - Total Inventory Value: KES " . number_format($products->sum(fn($p) => $p->quantity_in_stock * $p->cost_price), 2) . "\n";
} else {
    echo "  (No products yet - run seeder or create manually)\n";
}

echo "\n=== Test Complete ===\n";
