<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->enum('category', ['coffee', 'ganoderma', 'supplements', 'skincare', 'beverages', 'personal-care', 'other']);
            $table->string('image')->default('');
            $table->json('images')->nullable();
            $table->boolean('in_stock')->default(true);
            $table->unsignedInteger('stock_count')->default(0);
            $table->string('sku')->unique()->nullable();
            $table->json('benefits')->nullable();
            $table->text('ingredients')->nullable();
            $table->text('usage')->nullable();
            $table->boolean('featured')->default(false);
            $table->string('dxn_id')->default('');
            $table->string('source_url')->default('');
            $table->string('dxn_category')->default('');
            $table->decimal('rating', 3, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
