<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('blogs', 'content_ar')) {
            Schema::table('blogs', function (Blueprint $table) {
                $table->longText('content_ar')->nullable()->after('content');
            });
        }
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('content_ar');
        });
    }
};
