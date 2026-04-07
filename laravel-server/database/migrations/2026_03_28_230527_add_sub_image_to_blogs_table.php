<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('blogs', 'sub_image')) {
            Schema::table('blogs', function (Blueprint $table) {
                $table->string('sub_image')->default('')->after('image');
            });
        }
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('sub_image');
        });
    }
};
