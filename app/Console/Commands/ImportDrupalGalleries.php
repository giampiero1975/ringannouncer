<?php

namespace App\Console\Commands;

use App\Models\Gallery;
use App\Models\Media;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportDrupalGalleries extends Command
{
    protected $signature = 'ring:import-galleries {--dry-run : Analizza senza scrivere nel nuovo database}';

    protected $description = 'Importa gallery e riferimenti immagini dal Drupal 7';

    private const EXPECTED_GALLERIES = 2;
    private const EXPECTED_IMAGES = 47;

    public function handle(): int
    {
        $legacy = DB::connection('legacy_drupal');

        $galleryRows = $legacy->table('node as n')
            ->leftJoin('field_data_body as b', function ($join) {
                $join->on('b.entity_id', '=', 'n.nid')
                    ->where('b.entity_type', '=', 'node')
                    ->where('b.bundle', '=', 'gallery')
                    ->where('b.deleted', '=', 0)
                    ->where('b.delta', '=', 0);
            })
            ->where('n.type', 'gallery')
            ->orderBy('n.nid')
            ->select([
                'n.nid',
                'n.title',
                'n.status as drupal_status',
                'n.created',
                'b.body_value',
            ])
            ->get();

        $this->info('Gallery Drupal trovate: '.$galleryRows->count());

        if ($galleryRows->count() !== self::EXPECTED_GALLERIES) {
            $this->warn('Gate audit gallery: attese '.self::EXPECTED_GALLERIES.'.');
        }

        $imageRows = $legacy->table('field_data_field_picture as p')
            ->join('file_managed as f', 'f.fid', '=', 'p.field_picture_fid')
            ->where('p.entity_type', 'node')
            ->where('p.bundle', 'gallery')
            ->where('p.deleted', 0)
            ->orderBy('p.entity_id')
            ->orderBy('p.delta')
            ->select([
                'p.entity_id',
                'p.delta',
                'p.field_picture_fid',
                'p.field_picture_alt',
                'p.field_picture_title',
                'f.filename',
                'f.uri',
                'f.filemime',
            ])
            ->get();

        $this->info('Immagini gallery Drupal trovate: '.$imageRows->count());

        if ($imageRows->count() !== self::EXPECTED_IMAGES) {
            $this->warn('Gate audit immagini: attese '.self::EXPECTED_IMAGES.'.');
        }

        $errors = 0;
        $galleryMap = [];

        foreach ($galleryRows as $row) {
            try {
                $slug = Str::slug($row->title).'-'.$row->nid;

                if (! $this->option('dry-run')) {
                    $gallery = Gallery::updateOrCreate(
                        ['legacy_drupal_id' => $row->nid],
                        [
                            'title' => $row->title,
                            'slug' => $slug,
                            'description' => $row->body_value,
                            'published_at' => $row->created ? date('Y-m-d H:i:s', $row->created) : null,
                            'is_published' => (bool) $row->drupal_status,
                        ],
                    );

                    $galleryMap[(int) $row->nid] = $gallery->id;
                }
            } catch (\Throwable $exception) {
                $errors++;
                $this->error("Gallery nid {$row->nid}: {$exception->getMessage()}");
            }
        }

        $imagesProcessed = 0;

        foreach ($imageRows as $row) {
            try {
                if (! $this->option('dry-run')) {
                    $galleryId = $galleryMap[(int) $row->entity_id]
                        ?? Gallery::where('legacy_drupal_id', $row->entity_id)->value('id');

                    if (! $galleryId) {
                        throw new \RuntimeException('Gallery Laravel non trovata per entity_id '.$row->entity_id);
                    }

                    Media::updateOrCreate(
                        ['legacy_file_id' => $row->field_picture_fid],
                        [
                            'gallery_id' => $galleryId,
                            'type' => 'image',
                            'file_path' => 'legacy-drupal/'.basename($row->uri),
                            'original_name' => $row->filename,
                            'title' => $row->field_picture_title,
                            'alt_text' => $row->field_picture_alt,
                            'sort_order' => (int) $row->delta,
                        ],
                    );
                }

                $imagesProcessed++;
            } catch (\Throwable $exception) {
                $errors++;
                $this->error("File fid {$row->field_picture_fid}: {$exception->getMessage()}");
            }
        }

        $mode = $this->option('dry-run') ? 'DRY RUN' : 'IMPORT';
        $this->newLine();
        $this->info("{$mode} gallery completato: {$galleryRows->count()} gallery, {$imagesProcessed} immagini, {$errors} errori.");

        if (! $this->option('dry-run')) {
            $this->info('Gallery Laravel legacy: '.Gallery::whereNotNull('legacy_drupal_id')->count());
            $this->info('Media Laravel legacy: '.Media::whereNotNull('legacy_file_id')->count());
        }

        return $errors === 0 ? self::SUCCESS : self::FAILURE;
    }
}
