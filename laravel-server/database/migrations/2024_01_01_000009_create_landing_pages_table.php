<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('hero_image')->default('');
            $table->string('hero_title');
            $table->text('hero_subtitle')->default('');
            $table->string('hero_bg_color')->default('#371c9b');
            $table->string('cta_text')->default('Order Now via WhatsApp');
            $table->string('cta_link')->default('https://wa.me/message/EFSQ2IDNVG3YB1');
            $table->text('features')->nullable(); // JSON array of features
            $table->text('benefits')->nullable(); // JSON array of benefits
            $table->text('gallery')->nullable(); // JSON array of image URLs
            $table->text('custom_css')->nullable();
            $table->text('custom_html')->nullable(); // Extra HTML sections
            $table->boolean('published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('landing_pages');
    }
};
