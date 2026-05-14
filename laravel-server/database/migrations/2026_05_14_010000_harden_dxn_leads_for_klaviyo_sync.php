<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dxn_leads', function (Blueprint $table) {
            if (! Schema::hasColumn('dxn_leads', 'idempotency_key')) {
                $table->string('idempotency_key', 120)->nullable()->unique()->after('payload');
            }

            if (! Schema::hasColumn('dxn_leads', 'klaviyo_retry_count')) {
                $table->unsignedInteger('klaviyo_retry_count')->default(0)->after('klaviyo_error');
            }

            if (! Schema::hasColumn('dxn_leads', 'klaviyo_last_attempted_at')) {
                $table->timestamp('klaviyo_last_attempted_at')->nullable()->after('klaviyo_retry_count');
            }

            if (! Schema::hasColumn('dxn_leads', 'klaviyo_next_retry_at')) {
                $table->timestamp('klaviyo_next_retry_at')->nullable()->after('klaviyo_last_attempted_at');
            }

            if (! Schema::hasColumn('dxn_leads', 'klaviyo_profile_id')) {
                $table->string('klaviyo_profile_id', 100)->nullable()->after('klaviyo_next_retry_at');
            }

            if (! Schema::hasColumn('dxn_leads', 'klaviyo_subscription_job_id')) {
                $table->string('klaviyo_subscription_job_id', 100)->nullable()->after('klaviyo_profile_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('dxn_leads', function (Blueprint $table) {
            foreach ([
                'idempotency_key',
                'klaviyo_retry_count',
                'klaviyo_last_attempted_at',
                'klaviyo_next_retry_at',
                'klaviyo_profile_id',
                'klaviyo_subscription_job_id',
            ] as $column) {
                if (Schema::hasColumn('dxn_leads', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
