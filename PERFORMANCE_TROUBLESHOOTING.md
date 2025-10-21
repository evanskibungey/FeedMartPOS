# 🔧 PERFORMANCE OPTIMIZATION - TROUBLESHOOTING GUIDE

## 🆘 Common Issues and Solutions

### Issue 1: Migration Fails

#### Symptom:
```bash
php artisan migrate
# Error: SQLSTATE[42000]: Syntax error or access violation: 1061 Duplicate key name
```

#### Solution:
```bash
# Check which migrations have run
php artisan migrate:status

# If indexes already exist, skip this migration
# OR manually remove existing indexes first:
php artisan tinker
>>> DB::statement('DROP INDEX idx_products_status ON products');
>>> exit

# Then run migration again
php artisan migrate
```

---

### Issue 2: Still Slow After Optimization

#### Symptom:
Pages still loading slowly (> 2 seconds)

#### Diagnosis:
```bash
# 1. Install Laravel Debugbar
composer require barryvdh/laravel-debugbar --dev

# 2. Visit a slow page and check:
# - Number of queries (should be < 10)
# - Query execution time (should be < 100ms total)
# - Memory usage (should be < 10MB)
```

#### Solutions:

**If Query Count is High (> 15):**
```php
// Check for N+1 queries in your code
// Look for relationship access in loops without eager loading

// Bad:
foreach ($products as $product) {
    echo $product->category->name;  // N+1!
}

// Good:
$products = Product::with('category')->get();
foreach ($products as $product) {
    echo $product->category->name;  // Already loaded
}
```

**If Queries are Slow (> 100ms each):**
```bash
# Check if indexes are properly created
php artisan tinker
>>> DB::select('SHOW INDEX FROM products');

# Should see multiple indexes listed
# If not, migration didn't run properly
```

**If Memory Usage is High (> 20MB):**
```php
// Check if you're loading too much data
// Use select() to limit columns
// Use pagination to limit rows

// Bad:
$products = Product::all();  // Loads everything!

// Good:
$products = Product::select('id', 'name')->paginate(15);
```

---

### Issue 3: Cache Not Working

#### Symptom:
Pages are still slow, cache doesn't seem to help

#### Check Cache Configuration:
```bash
# Check .env file
cat .env | grep CACHE

# Should see:
# CACHE_DRIVER=file  (or redis, memcached)
```

#### Clear and Test Cache:
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Test cache manually
php artisan tinker
>>> cache()->put('test', 'value', 60);
>>> cache()->get('test');
# Should return: "value"
>>> exit
```

#### Check Cache Permissions:
```bash
# On Windows:
# Ensure storage/framework/cache has write permissions

# Check if cache directory exists
dir storage\framework\cache

# If not, create it:
mkdir storage\framework\cache\data
```

---

### Issue 4: Specific Pages Still Slow

#### Dashboard Slow?

**Check:**
```bash
# 1. Is cache working?
php artisan tinker
>>> cache()->has('admin_dashboard_stats_' . now()->format('YmdHi'));
# Should return: true after first load

# 2. Check query count
# Install debugbar and visit dashboard
# Should see ~15 queries
```

**Solutions:**
```php
// If cache isn't working, check AdminDashboardController.php
// Ensure Cache facade is imported:
use Illuminate\Support\Facades\Cache;

// Check cache duration is appropriate
Cache::remember($key, now()->addMinutes(5), function() {
    // ...
});
```

#### Products Page Slow?

**Check:**
```bash
# View page with debugbar
# Should see 4-5 queries maximum
```

**Common Issues:**
```php
// Issue: Loading all columns
// Fix: Use select()
Product::select('id', 'name', 'price', 'category_id')
    ->with('category:id,name')
    ->paginate(15);

// Issue: Not caching dropdowns
// Fix: Add caching
$categories = cache()->remember('active_categories', 1800, function() {
    return Category::select('id', 'name')->active()->get();
});
```

---

### Issue 5: Database Connection Errors

#### Symptom:
```
SQLSTATE[HY000] [2002] Connection refused
```

#### Solution:
```bash
# Check if MySQL is running
# In XAMPP Control Panel, ensure MySQL is started

# Check database credentials in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=feedmart_pos
DB_USERNAME=root
DB_PASSWORD=

# Test connection
php artisan tinker
>>> DB::connection()->getPdo();
# Should connect without error
```

---

### Issue 6: Indexes Not Improving Performance

#### Symptom:
Migrations ran successfully but queries still slow

#### Check Index Usage:
```sql
-- Run in MySQL/phpMyAdmin
EXPLAIN SELECT * FROM products WHERE status = 'active';

-- Should show:
-- type: ref (not ALL)
-- possible_keys: idx_products_status
-- key: idx_products_status
```

#### Force Index Usage:
```php
// If MySQL isn't using indexes, force it:
Product::from('products USE INDEX (idx_products_status)')
    ->where('status', 'active')
    ->get();
```

#### Rebuild Indexes:
```sql
-- In phpMyAdmin or MySQL client
ANALYZE TABLE products;
OPTIMIZE TABLE products;
```

---

### Issue 7: Out of Memory Errors

#### Symptom:
```
Allowed memory size of X bytes exhausted
```

#### Quick Fix:
```php
// In php.ini (or .htaccess)
memory_limit = 256M

// Or set in code (temporarily)
ini_set('memory_limit', '256M');
```

#### Better Solution:
```php
// Don't load everything at once
// Use chunking for large datasets
Product::chunk(100, function ($products) {
    foreach ($products as $product) {
        // Process product
    }
});

// Or use lazy loading
Product::lazy()->each(function ($product) {
    // Process product
});
```

---

### Issue 8: Cache Serving Stale Data

#### Symptom:
Updated data not showing immediately

#### Understanding Cache TTL:
```php
// Cache durations we're using:
Dashboard stats: 5 minutes
Categories/Brands: 30 minutes
Top Products: 30 minutes
```

#### Manual Cache Clear:
```bash
# Clear specific cache keys
php artisan tinker
>>> cache()->forget('active_categories');
>>> cache()->forget('active_brands');
>>> cache()->forget('admin_dashboard_stats_*');  # Won't work with wildcards
```

#### Clear All Cache:
```bash
php artisan cache:clear
```

#### Implement Cache Invalidation:
```php
// In Category model, add event listener
protected static function booted()
{
    static::saved(function () {
        cache()->forget('active_categories');
    });
    
    static::deleted(function () {
        cache()->forget('active_categories');
    });
}
```

---

## 🔍 Debugging Tools

### 1. Laravel Debugbar

**Installation:**
```bash
composer require barryvdh/laravel-debugbar --dev
```

**Usage:**
- Automatically appears at bottom of page
- Shows queries, execution time, memory usage
- Click on queries to see SQL and bindings

**What to Look For:**
- Query count: Should be < 10 per page
- Duplicate queries: Indicates missing eager loading
- Slow queries: > 100ms needs optimization

### 2. Query Logging

**Enable in AppServiceProvider:**
```php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

public function boot()
{
    if (config('app.debug')) {
        DB::listen(function($query) {
            Log::channel('query')->info(
                $query->sql,
                [
                    'bindings' => $query->bindings,
                    'time' => $query->time . 'ms'
                ]
            );
        });
    }
}
```

**View Logs:**
```bash
tail -f storage/logs/laravel.log
# or
tail -f storage/logs/query.log
```

### 3. Browser DevTools

**Network Tab:**
1. Open DevTools (F12)
2. Go to Network tab
3. Reload page
4. Check "Time" column

**Look For:**
- Total page load: Should be < 1s
- Backend response: Should be < 500ms
- Large payloads: Reduce data transfer

---

## 📊 Performance Benchmarking

### Measure Query Performance:

```php
use Illuminate\Support\Facades\DB;

// Start timing
$start = microtime(true);

// Your query
$products = Product::with('category')->paginate(15);

// End timing
$time = microtime(true) - $start;
echo "Query took: " . round($time * 1000, 2) . "ms\n";

// Show query count
echo "Queries executed: " . count(DB::getQueryLog()) . "\n";
```

### Test Caching Effectiveness:

```php
// First load (cache miss)
$start = microtime(true);
$categories = cache()->remember('categories', 1800, function() {
    return Category::all();
});
$firstLoadTime = microtime(true) - $start;

// Second load (cache hit)
$start = microtime(true);
$categories = cache()->remember('categories', 1800, function() {
    return Category::all();
});
$secondLoadTime = microtime(true) - $start;

echo "First load: " . round($firstLoadTime * 1000, 2) . "ms\n";
echo "Second load: " . round($secondLoadTime * 1000, 2) . "ms\n";
echo "Improvement: " . round(($firstLoadTime / $secondLoadTime), 2) . "x\n";
```

---

## ✅ Verification Checklist

After troubleshooting, verify:

```
□ Migration completed successfully
□ All indexes created (check with SHOW INDEX)
□ Cache is working (test with cache()->get/put)
□ Dashboard loads in < 1 second
□ Products page loads in < 0.5 seconds
□ Query count < 10 per page (check debugbar)
□ No N+1 queries detected
□ No memory errors
□ Cache invalidates properly when data changes
□ All CRUD operations still work
□ Filters and search still functional
```

---

## 🚨 When to Get Help

Contact support if:

1. Migration fails repeatedly with errors
2. Indexes aren't being used (EXPLAIN shows type: ALL)
3. Memory errors persist after optimization
4. Cache doesn't work even after clearing
5. Pages are still > 2 seconds after all fixes
6. Database errors appear after migration

---

## 📞 Support Resources

### Logs to Check:
```bash
storage/logs/laravel.log    # Application errors
storage/logs/query.log      # SQL queries (if enabled)
```

### Useful Commands:
```bash
# Check PHP version
php -v

# Check Laravel version
php artisan --version

# List all migrations
php artisan migrate:status

# Check database connection
php artisan tinker
>>> DB::connection()->getPdo();

# View configuration
php artisan config:show database

# Clear everything
php artisan optimize:clear
```

---

**Remember**: Most issues are caused by:
1. Migration not running properly
2. Cache not configured correctly
3. Missing eager loading
4. Not selecting only needed columns

Start with the basics and work your way up! 🚀
