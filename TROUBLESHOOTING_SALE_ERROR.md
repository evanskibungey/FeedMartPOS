# 🔧 TROUBLESHOOTING GUIDE - Sale Processing Error

## Issue: "Failed to process sale" error

Let's fix this step by step.

---

## Step 1: Run These Commands in Order

Open Command Prompt/Terminal and navigate to your project:

```bash
cd C:\xampp\htdocs\FeedMartPOS
```

### 1.1: Clear All Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### 1.2: Check if tables exist
```bash
php artisan migrate:status
```

**What to look for:**
- If you see "No migrations found" → Go to Step 2
- If you see a list of migrations → Check if the last 2 are:
  - `2025_01_15_000009_create_sales_table`
  - `2025_01_15_000010_create_sale_items_table`
  
**If these are marked as "Ran"**: Go to Step 3  
**If these are marked as "Pending"**: Run this command:

```bash
php artisan migrate
```

---

## Step 2: If "No migrations found" error

This means Laravel can't find the migrations. Let's verify the files exist:

### 2.1: Check migration files exist
In File Explorer, navigate to:
```
C:\xampp\htdocs\FeedMartPOS\database\migrations
```

You should see these files:
- `2025_01_15_000009_create_sales_table.php` ✓
- `2025_01_15_000010_create_sale_items_table.php` ✓

**If files exist**: Run these commands:
```bash
composer dump-autoload
php artisan migrate:status
```

**If files don't exist**: The files weren't created. Tell me and I'll recreate them.

---

## Step 3: Check Database Tables

### 3.1: Open phpMyAdmin
Go to: `http://localhost/phpmyadmin`

### 3.2: Select your database
Click on your database name (probably `feedmart_pos`)

### 3.3: Check for these tables:
- [ ] `sales`
- [ ] `sale_items`

**If tables DON'T exist**: Run this in terminal:
```bash
php artisan migrate
```

**If tables exist**: Go to Step 4

---

## Step 4: Check Browser Console for Errors

### 4.1: Open Developer Tools
- In your browser, press **F12**
- Click on the **Console** tab

### 4.2: Try to complete a sale
- Add items to cart
- Click "Complete Sale"
- Watch the Console tab

### 4.3: What errors do you see?

**Common errors and solutions:**

#### Error: "404 Not Found" for /pos/sales
**Solution:**
```bash
php artisan route:clear
php artisan config:clear
```

#### Error: "419 Page Expired" or "CSRF token mismatch"
**Solution:**
- Refresh the page (Ctrl + F5)
- Clear browser cookies
- Try in incognito/private window

#### Error: "500 Internal Server Error"
**Solution:** Check Laravel logs (see Step 5)

#### Error: "Class 'App\Models\Sale' not found"
**Solution:**
```bash
composer dump-autoload
php artisan cache:clear
```

---

## Step 5: Check Laravel Error Logs

### 5.1: Open the log file
Navigate to:
```
C:\xampp\htdocs\FeedMartPOS\storage\logs\laravel.log
```

### 5.2: Scroll to the bottom
Look for recent errors (today's date/time)

### 5.3: Common errors and fixes:

#### "SQLSTATE[42S02]: Base table or view not found: 'sales'"
**Means:** Tables not created  
**Fix:** Run `php artisan migrate`

#### "Class 'App\Models\Sale' not found"
**Means:** Model file missing or not autoloaded  
**Fix:** 
```bash
composer dump-autoload
php artisan cache:clear
```

#### "Call to undefined method"
**Means:** Controller method missing  
**Fix:** Verify SaleController.php exists in `app/Http/Controllers/POS/`

---

## Step 6: Verify Files Exist

Check these files exist in your project:

### Models:
- [ ] `app/Models/Sale.php`
- [ ] `app/Models/SaleItem.php`

### Controller:
- [ ] `app/Http/Controllers/POS/SaleController.php`

### Migrations:
- [ ] `database/migrations/2025_01_15_000009_create_sales_table.php`
- [ ] `database/migrations/2025_01_15_000010_create_sale_items_table.php`

**If any file is missing**: Let me know which one and I'll recreate it.

---

## Step 7: Test Database Connection

### 7.1: Run the diagnostic script
```bash
php check-setup.php
```

This will show you exactly what's missing.

### 7.2: Or test manually in terminal:
```bash
php artisan tinker
```

Then type:
```php
\App\Models\Sale::count()
```

**Expected:** A number (even if 0)  
**If error:** Note the exact error message

Type `exit` to leave tinker.

---

## Step 8: Manual Migration (If all else fails)

If migrations won't run automatically, run this SQL directly in phpMyAdmin:

### 8.1: Open phpMyAdmin
Go to your database, click on "SQL" tab

### 8.2: Run this SQL (Sales Table):
```sql
CREATE TABLE IF NOT EXISTS `sales` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `receipt_number` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `tax_amount` decimal(12,2) NOT NULL,
  `tax_rate` decimal(5,2) NOT NULL DEFAULT 16.00,
  `total_amount` decimal(12,2) NOT NULL,
  `payment_method` enum('cash','mpesa','card','bank_transfer') NOT NULL DEFAULT 'cash',
  `payment_reference` varchar(255) DEFAULT NULL,
  `status` enum('completed','pending','cancelled','refunded') NOT NULL DEFAULT 'completed',
  `notes` text DEFAULT NULL,
  `sale_date` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sales_receipt_number_unique` (`receipt_number`),
  KEY `sales_user_id_index` (`user_id`),
  KEY `sales_sale_date_index` (`sale_date`),
  KEY `sales_status_index` (`status`),
  CONSTRAINT `sales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 8.3: Run this SQL (Sale Items Table):
```sql
CREATE TABLE IF NOT EXISTS `sale_items` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_sku` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sale_items_sale_id_index` (`sale_id`),
  KEY `sale_items_product_id_index` (`product_id`),
  CONSTRAINT `sale_items_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sale_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 8.4: Verify tables created:
In phpMyAdmin, check that you now see `sales` and `sale_items` tables.

---

## Step 9: Test Again

After fixing the issues:

### 9.1: Clear everything again:
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### 9.2: Refresh browser (Ctrl + F5)

### 9.3: Try completing a sale again

---

## Quick Checklist - Copy this and fill in:

```
[  ] Ran: php artisan cache:clear
[  ] Ran: php artisan migrate
[  ] Tables exist in database (sales, sale_items)
[  ] Files exist (Sale.php, SaleItem.php, SaleController.php)
[  ] No errors in browser console (F12)
[  ] No errors in laravel.log
[  ] Routes registered (php artisan route:list | grep sales)
```

---

## If Still Not Working...

### Please provide me with:

1. **Output of:** `php artisan migrate:status`
2. **Output of:** `php check-setup.php`
3. **Last 20 lines of:** `storage/logs/laravel.log`
4. **Browser console errors** (F12 → Console tab screenshot)
5. **Which step failed** from this guide

I'll help you fix it!

---

## Emergency: Reset Everything

If nothing works and you want to start fresh:

```bash
# WARNING: This will delete all data!
php artisan migrate:fresh

# Then run migrations again
php artisan migrate

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

**Note:** This will delete ALL data including products, users, etc. Only use as last resort!
