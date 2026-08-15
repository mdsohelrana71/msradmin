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
        Schema::create('product_prices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->foreignId('product_variant_value_id')
                ->nullable()
                ->constrained('product_variant_values')
                ->cascadeOnDelete();

            $table->decimal('price', 12, 2);
            $table->decimal('discount_price', 12, 2)->nullable();

            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_prices');
    }
};
