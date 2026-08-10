<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('author_id')->constrained()->cascadeOnDelete();
            $table->foreignId('publisher_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('isbn')->unique();
            $table->string('edition')->nullable();
            $table->string('language')->default('English');
            $table->decimal('price', 8, 2);
            $table->integer('quantity');
            $table->integer('available_quantity');
            $table->year('publish_year')->nullable();
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->enum('status', ['available', 'out_of_stock'])->default('available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};