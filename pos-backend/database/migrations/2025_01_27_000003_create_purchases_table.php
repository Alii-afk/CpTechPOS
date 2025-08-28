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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->foreignId('business_location_id')->constrained('business_locations');
            $table->foreignId('created_by')->constrained('users'); // User who created the purchase
            
            // Purchase Information
            $table->string('reference_no')->unique();
            $table->date('purchase_date');
            $table->text('purchase_note')->nullable();
            $table->string('document')->nullable(); // File path for attached document
            
            // Payment Information
            $table->decimal('total_amount', 12, 2)->default(0.00);
            $table->decimal('paid_amount', 12, 2)->default(0.00);
            $table->decimal('due_amount', 12, 2)->default(0.00);
            $table->enum('payment_status', ['pending', 'paid', 'partial'])->default('pending');
            $table->enum('payment_method', ['cash', 'card', 'check', 'bank_transfer'])->nullable();
            
            // Purchase Status
            $table->enum('status', ['draft', 'ordered', 'received', 'cancelled'])->default('draft');
            $table->boolean('is_active')->default(true);
            
            // Timestamps
            $table->timestamps();
            
            // Indexes
            $table->index(['supplier_id', 'purchase_date']);
            $table->index(['business_location_id', 'status']);
            $table->index(['payment_status', 'created_at']);
            $table->index('reference_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
}; 