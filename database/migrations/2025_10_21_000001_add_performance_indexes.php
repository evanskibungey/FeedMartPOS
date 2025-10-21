<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add indexes to products table
        Schema::table('products', function (Blueprint $table) {
            $table->index('status', 'idx_products_status');
            $table->index('quantity_in_stock', 'idx_products_qty');
            $table->index(['status', 'quantity_in_stock'], 'idx_products_status_qty');
            $table->index('category_id', 'idx_products_category');
            $table->index('brand_id', 'idx_products_brand');
        });

        // Add indexes to users table
        Schema::table('users', function (Blueprint $table) {
            $table->index('role', 'idx_users_role');
            $table->index('is_active', 'idx_users_active');
            $table->index(['role', 'is_active'], 'idx_users_role_active');
        });

        // Add indexes to orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->index('status', 'idx_orders_status');
            $table->index('user_id', 'idx_orders_user');
            $table->index('created_at', 'idx_orders_created');
            $table->index(['status', 'created_at'], 'idx_orders_status_created');
        });

        // Add indexes to sales table
        Schema::table('sales', function (Blueprint $table) {
            $table->index('status', 'idx_sales_status');
            $table->index('user_id', 'idx_sales_user');
            $table->index('sale_date', 'idx_sales_date');
            $table->index(['status', 'sale_date'], 'idx_sales_status_date');
            $table->index('payment_method', 'idx_sales_payment');
        });

        // Add indexes to purchase_orders table
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->index('status', 'idx_po_status');
            $table->index('supplier_id', 'idx_po_supplier');
            $table->index('created_by', 'idx_po_creator');
            $table->index('created_at', 'idx_po_created');
        });

        // Add indexes to categories and brands
        Schema::table('categories', function (Blueprint $table) {
            $table->index('is_active', 'idx_categories_active');
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->index('is_active', 'idx_brands_active');
        });

        Schema::table('suppliers', function (Blueprint $table) {
            $table->index('is_active', 'idx_suppliers_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('idx_products_status');
            $table->dropIndex('idx_products_qty');
            $table->dropIndex('idx_products_status_qty');
            $table->dropIndex('idx_products_category');
            $table->dropIndex('idx_products_brand');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_users_role');
            $table->dropIndex('idx_users_active');
            $table->dropIndex('idx_users_role_active');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('idx_orders_status');
            $table->dropIndex('idx_orders_user');
            $table->dropIndex('idx_orders_created');
            $table->dropIndex('idx_orders_status_created');
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->dropIndex('idx_sales_status');
            $table->dropIndex('idx_sales_user');
            $table->dropIndex('idx_sales_date');
            $table->dropIndex('idx_sales_status_date');
            $table->dropIndex('idx_sales_payment');
        });

        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->dropIndex('idx_po_status');
            $table->dropIndex('idx_po_supplier');
            $table->dropIndex('idx_po_creator');
            $table->dropIndex('idx_po_created');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('idx_categories_active');
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->dropIndex('idx_brands_active');
        });

        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropIndex('idx_suppliers_active');
        });
    }
};
