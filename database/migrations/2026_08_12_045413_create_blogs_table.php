<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')
                ->constrained('categories')
                ->restrictOnDelete();

            $table->string('title');
            $table->string('slug')->unique();

            $table->string('excerpt', 500)->nullable();

            $table->longText('content');

            $table->string('featured_image')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();

            $table->index('category_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};