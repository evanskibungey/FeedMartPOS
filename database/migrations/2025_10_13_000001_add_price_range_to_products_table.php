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
        Schema::table('products', function (Blueprint $table) {
            // Add minimum selling price (lowest allowable price)
            $table->decimal('min_selling_price', 10, 2)->after('price')->nullable();
            
            // Rename 'price' to 'max_selling_price' conceptually, but keep the column name for backwards compatibility
            // Add a new column for maximum selling price (current selling price acts as maximum)
            $table->decimal('max_selling_price', 10, 2)->after('min_selling_price')->nullable();
            
            // Set default values for existing products - max_selling_price = current price, min = cost_price
            // This will be handled in a separate data migration or manually
        });

        // Update existing products to set max_selling_price from price and min_selling_price from cost_price
        DB::statement('UPDATE products SET max_selling_price = price, min_selling_price = cost_price WHERE max_selling_price IS NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['min_selling_price', 'max_selling_price']);
        });
    }
};
