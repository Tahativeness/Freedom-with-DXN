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
        if (!Schema::hasColumn('landing_pages', 'description')) {
            Schema::table('landing_pages', function (Blueprint $table) {
                $table->text('description')->nullable()->after('hero_bg_color');
                $table->text('description_ar')->nullable()->after('description');
                $table->text('ingredients')->nullable()->after('description_ar');
                $table->text('usage_directions')->nullable()->after('ingredients');
                $table->text('usage_directions_ar')->nullable()->after('usage_directions');
                $table->json('qna')->nullable()->after('usage_directions_ar');
            });
        }
    }

    public function down(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->dropColumn(['description', 'description_ar', 'ingredients', 'usage_directions', 'usage_directions_ar', 'qna']);
        });
    }
};
