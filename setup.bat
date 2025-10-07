@echo off
echo ========================================
echo FeedMart POS - Quick Setup Commands
echo ========================================
echo.

echo [1/5] Running migrations...
php artisan migrate
echo.

echo [2/5] Creating storage link...
php artisan storage:link
echo.

echo [3/5] Seeding database with sample data...
echo   - Creating 7 categories
echo   - Creating 7 brands
echo   - Creating 5 suppliers
echo   - Creating 20 products
php artisan db:seed
echo.

echo [4/5] Clearing caches...
php artisan cache:clear
php artisan config:clear
php artisan view:clear
echo.

echo [5/5] Building assets...
call npm install
call npm run build
echo.

echo ========================================
echo Setup Complete!
echo ========================================
echo.
echo You can now:
echo 1. Login to admin panel: http://localhost/FeedMartPOS/public/admin/login
echo 2. Create products with pre-populated categories and brands
echo 3. Test the full inventory system
echo.
echo Check PRODUCT_CREATION_FIX.md for details.
echo.
pause
