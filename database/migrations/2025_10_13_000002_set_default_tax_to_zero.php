<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update all existing products to have 0% tax rate if they have 16%
        // This makes tax optional - admin can set it per product
        DB::table('products')
            ->where('tax_rate', 16.00)
            ->update(['tax_rate' => 0.00]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optionally revert back to 16% if needed
        DB::table('products')
            ->where('tax_rate', 0.00)
            ->update(['tax_rate' => 16.00]);
    }
};
