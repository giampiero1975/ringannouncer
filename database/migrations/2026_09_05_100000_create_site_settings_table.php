<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('hero_eyebrow')->default('SPORT · EMOZIONI · PERSONE');
            $table->string('hero_line_1')->default('UNA VOCE');
            $table->string('hero_line_2')->default('OLTRE');
            $table->string('hero_line_3')->default('IL RING');
            $table->text('hero_intro')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('hero_cta_text')->default('SCOPRI CHI SONO');
            $table->string('hero_cta_url')->default('#bio');
            $table->string('hero_video_text')->default('GUARDA IL VIDEO');
            $table->string('hero_video_url')->default('#media');
            $table->string('signature_name')->default('Valerio');
            $table->string('hero_side_line_1')->default('PASSION');
            $table->string('hero_side_line_2')->default('DISCIPLINE');
            $table->string('hero_side_line_3')->default('RESPECT');

            $table->string('events_eyebrow')->default('NEXT');
            $table->string('events_title')->default('PROSSIMI EVENTI');
            $table->text('events_intro')->nullable();

            $table->string('gallery_eyebrow')->default('GALLERY');
            $table->string('gallery_title')->default('MOMENTI CHE RESTANO');
            $table->text('gallery_intro')->nullable();

            $table->string('bio_eyebrow')->default('BIOGRAFIA');
            $table->string('bio_title')->default('VALERIO');
            $table->longText('bio_body')->nullable();
            $table->text('bio_quote')->nullable();
            $table->string('bio_image')->nullable();

            $table->string('stat_events')->default('100+');
            $table->string('stat_events_label')->default('EVENTI ANNUNCIATI');
            $table->string('stat_cities')->default('50+');
            $table->string('stat_cities_label')->default('CITTÀ IN ITALIA ED EUROPA');
            $table->string('stat_disciplines')->default('10+');
            $table->string('stat_disciplines_label')->default('DISCIPLINE SPORTIVE');
            $table->string('stat_unique')->default('UNICA');
            $table->string('stat_unique_label')->default('UNA GRANDE PASSIONE');

            $table->string('cta_eyebrow')->default('IL RING CONTINUA');
            $table->string('cta_title')->default('READY FOR THE NEXT ROUND?');
            $table->string('cta_text')->default('PER EVENTI, COLLABORAZIONI E INFORMAZIONI');
            $table->string('cta_button_text')->default('SCRIVIMI');
            $table->string('cta_button_url')->default('#contatti');
            $table->string('cta_background_image')->nullable();
            $table->string('footer_tagline')->default('Passione. Ring. Persone.');
            $table->timestamps();
        });

        DB::table('site_settings')->insert([
            'hero_intro' => 'Eventi, match, persone. Ogni grande spettacolo inizia con una grande voce.',
            'events_intro' => 'Vivi dal vivo l’energia dei grandi match. Scopri dove sarò il prossimo.',
            'gallery_intro' => 'Immagini, backstage ed emozioni da dentro e fuori dal ring.',
            'bio_body' => 'Ring announcer, speaker e presentatore specializzato in eventi di boxe, kickboxing, muay thai e MMA. Una passione per lo sport da sempre, una voce al servizio delle emozioni.',
            'bio_quote' => 'Lo sport è disciplina, rispetto e passione. Il mio compito è dare voce a tutto questo.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
