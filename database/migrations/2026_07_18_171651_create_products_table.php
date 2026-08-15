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

            $table->foreignId('category_id')
                ->constrained('product_categories')
                ->cascadeOnDelete();

            $table->foreignId('brand_id')
                ->nullable()
                ->constrained('product_brands')
                ->nullOnDelete();

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->string('barcode')->nullable();

            $table->string('thumbnail')->nullable();

            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();

            $table->decimal('cost_price', 12, 2)->default(0);
            $table->decimal('selling_price', 12, 2);
            $table->decimal('discount_price', 12, 2)->nullable();

            $table->integer('stock')->default(0);

            $table->decimal('weight', 8, 2)->nullable();
            $table->string('unit')->default('pcs');

            $table->boolean('is_featured')->default(false);
            $table->boolean('status')->default(true);

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
