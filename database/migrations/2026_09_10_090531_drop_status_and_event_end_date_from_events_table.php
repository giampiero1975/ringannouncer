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
        Schema::table('events', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['event_end_date', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dateTime('event_end_date')->nullable()->after('event_date');
            $table->string('status', 32)->default('completed')->index()->after('event_end_date');
        });
    }
};
