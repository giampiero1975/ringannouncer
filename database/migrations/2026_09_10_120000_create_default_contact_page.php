<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::table('pages')->where('key', 'contatti')->exists()) {
            return;
        }

        DB::table('pages')->insert([
            'key' => 'contatti',
            'title' => 'Contatti',
            'content' => '<p>Per eventi, collaborazioni e informazioni puoi contattare RingAnnouncer Valerio Lamanna.</p>',
            'is_published' => true,
            'seo_title' => 'Contatti',
            'seo_description' => 'Contatta RingAnnouncer Valerio Lamanna per eventi, collaborazioni e informazioni.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('pages')->where('key', 'contatti')->delete();
    }
};
