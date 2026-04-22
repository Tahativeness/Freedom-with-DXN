<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE `orders` MODIFY COLUMN `payment_method` ENUM('bank_transfer', 'cash', 'online', 'cod') NOT NULL DEFAULT 'bank_transfer'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `orders` MODIFY COLUMN `payment_method` ENUM('bank_transfer', 'cash', 'online') NOT NULL DEFAULT 'bank_transfer'");
    }
};
