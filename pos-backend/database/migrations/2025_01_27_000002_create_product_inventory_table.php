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
        Schema::create('product_inventory', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('purchase_id')->nullable(); // Will add foreign key constraint after purchases table is created
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers');
            $table->foreignId('business_location_id')->constrained('business_locations');
            
            // Inventory Details
            $table->integer('quantity');
            $table->decimal('purchase_price', 10, 2);
            $table->decimal('selling_price', 10, 2);
            $table->decimal('inclusive_tax_rate', 5, 2)->default(0.00); // Inclusive tax percentage
            $table->decimal('exclusive_tax_rate', 5, 2)->default(0.00); // Exclusive tax percentage
            $table->decimal('profit_margin', 5, 2)->default(0.00); // Percentage
            $table->decimal('tax_amount', 10, 2)->default(0.00); // Tax amount (separate field)
            $table->decimal('profit_amount', 10, 2)->default(0.00); // Profit amount (separate field)
            $table->decimal('one_item_amount', 10, 2)->default(0.00); // Selling price per unit (including tax and profit)
            $table->decimal('total_order_amount', 12, 2)->default(0.00); // Total amount for this product
            
            // Batch Information
            $table->string('batch_number')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('invoice_number')->nullable();
            
            // Inventory Type
            $table->enum('inventory_type', ['purchase', 'transfer', 'adjustment', 'return'])->default('purchase');
            $table->text('notes')->nullable();
            
            // Status
            $table->boolean('is_active')->default(true);
            
            // Timestamps
            $table->timestamps();
            
            // Indexes
            $table->index(['product_id', 'business_location_id']);
            $table->index(['supplier_id', 'created_at']);
            $table->index(['expiry_date', 'is_active']);
            $table->index(['inventory_type', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_inventory');
    }
}; 