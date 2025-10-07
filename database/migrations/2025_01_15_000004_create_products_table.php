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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku')->unique();
            $table->foreignId('category_id')->constrained('categories')->onDelete('restrict');
            $table->foreignId('brand_id')->constrained('brands')->onDelete('restrict');
            $table->text('description')->nullable();
            $table->string('unit')->default('50kg bag'); // e.g., 50kg bag, 10kg bag
            $table->integer('quantity_in_stock')->default(0);
            $table->integer('reorder_level')->default(10);
            $table->decimal('price', 10, 2); // Retail price
            $table->decimal('wholesale_price', 10, 2)->nullable();
            $table->decimal('cost_price', 10, 2); // Purchase/cost price
            $table->string('image')->nullable();
            $table->string('barcode')->nullable()->unique();
            $table->decimal('tax_rate', 5, 2)->default(0); // Percentage
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
