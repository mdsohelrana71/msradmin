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

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->foreignId('product_variant_value_id')
                ->nullable()
                ->constrained('product_variant_values')
                ->cascadeOnDelete();

            $table->integer('stock')->default(0);
            $table->integer('reserved_stock')->default(0);
            $table->integer('low_stock_alert')->default(5);

            $table->timestamps();
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
