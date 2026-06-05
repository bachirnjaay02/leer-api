<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('push_subscriptions', function (Blueprint $table) {
            $table->jsonb('prayer_times')->nullable(); // {fajr: "05:30", dhuhr: "13:15", ...}
            $table->string('timezone')->default('Africa/Dakar');
        });
    }

    public function down(): void
    {
        Schema::table('push_subscriptions', function (Blueprint $table) {
            $table->dropColumn(['prayer_times', 'timezone']);
        });
    }
};
