<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dxn_leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->index();
            $table->string('whatsapp', 40);
            $table->string('country_code', 20)->nullable();
            $table->string('country_name', 100)->nullable();
            $table->string('interest', 30);
            $table->string('seriousness', 30);
            $table->string('goal');
            $table->string('learn', 30);
            $table->string('score', 30)->index();
            $table->string('source')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->string('utm_source')->nullable();
            $table->string('utm_medium')->nullable();
            $table->string('utm_campaign')->nullable();
            $table->longText('payload')->nullable();
            $table->string('idempotency_key', 120)->nullable()->unique();
            $table->boolean('klaviyo_synced')->default(false);
            $table->string('klaviyo_sync_status', 30)->default('pending')->index();
            $table->timestamp('klaviyo_synced_at')->nullable();
            $table->text('klaviyo_error')->nullable();
            $table->unsignedInteger('klaviyo_retry_count')->default(0);
            $table->timestamp('klaviyo_last_attempted_at')->nullable();
            $table->timestamp('klaviyo_next_retry_at')->nullable();
            $table->string('klaviyo_profile_id', 100)->nullable();
            $table->string('klaviyo_subscription_job_id', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dxn_leads');
    }
};
