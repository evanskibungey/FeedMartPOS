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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_number')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict'); // Cashier who made the sale
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->decimal('subtotal', 12, 2);
            $table->decimal('tax_amount', 12, 2);
            $table->decimal('tax_rate', 5, 2)->default(16.00); // Tax percentage
            $table->decimal('total_amount', 12, 2);
            $table->enum('payment_method', ['cash', 'mpesa', 'card', 'bank_transfer'])->default('cash');
            $table->string('payment_reference')->nullable(); // For M-Pesa/card transactions
            $table->enum('status', ['completed', 'pending', 'cancelled', 'refunded'])->default('completed');
            $table->text('notes')->nullable();
            $table->timestamp('sale_date');
            $table->timestamps();

            // Indexes for faster queries
            $table->index('receipt_number');
            $table->index('user_id');
            $table->index('sale_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
