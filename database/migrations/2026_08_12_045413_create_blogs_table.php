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

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('title');
            $table->string('slug')->unique();

            $table->string('excerpt', 500)->nullable();
            $table->longText('content');

            $table->string('featured_image')->nullable();

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('canonical_url')->nullable();

            $table->boolean('status')->default(true);

            $table->dateTime('published_at')->nullable();

            $table->boolean('is_featured')->default(false);
            $table->boolean('allow_comments')->default(true);

            $table->string('og_image')->nullable();

            $table->timestamps();

            $table->index('category_id');
            $table->index('status');
            $table->index('published_at');
            $table->index('is_featured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};