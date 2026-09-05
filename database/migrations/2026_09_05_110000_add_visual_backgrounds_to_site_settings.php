<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('events_background_image')->nullable()->after('events_intro');
            $table->string('gallery_background_image')->nullable()->after('gallery_intro');
            $table->string('bio_background_image')->nullable()->after('bio_image');
            $table->string('footer_background_image')->nullable()->after('footer_tagline');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'events_background_image',
                'gallery_background_image',
                'bio_background_image',
                'footer_background_image',
            ]);
        });
    }
};
