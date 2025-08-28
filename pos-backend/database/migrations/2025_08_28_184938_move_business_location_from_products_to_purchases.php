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
        // Remove business_location_id from products table
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['business_location_id']);
            $table->dropColumn('business_location_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add business_location_id back to products table
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('business_location_id')->after('product_category_id');
            $table->foreign('business_location_id')->references('id')->on('business_locations')->onDelete('cascade');
        });
    }
};
