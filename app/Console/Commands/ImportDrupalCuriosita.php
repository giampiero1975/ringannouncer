<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportDrupalCuriosita extends Command
{
    protected $signature = 'ring:import-curiosita {--dry-run : Analizza senza scrivere nel nuovo database} {--limit= : Limita il numero di record per i test}';

    protected $description = 'Importa le Curiosità Drupal 7 negli articoli RingAnnouncer';

    private const EXPECTED_SOURCE_COUNT = 79;

    public function handle(): int
    {
        $legacy = DB::connection('legacy_drupal');

        $sourceCount = $legacy->table('node')
            ->where('type', 'curiosit_')
            ->count();

        $this->info("Curiosità Drupal trovate: {$sourceCount}");

        if ($sourceCount !== self::EXPECTED_SOURCE_COUNT) {
            $this->warn('Gate audit: attesi '.self::EXPECTED_SOURCE_COUNT.' record. Verificare il dump prima del go-live.');
        }

        $query = $legacy->table('node as n')
            ->leftJoin('field_data_body as b', function ($join) {
                $join->on('b.entity_id', '=', 'n.nid')
                    ->where('b.entity_type', '=', 'node')
                    ->where('b.bundle', '=', 'curiosit_')
                    ->where('b.deleted', '=', 0)
                    ->where('b.delta', '=', 0);
            })
            ->leftJoin('field_data_field_date as d', function ($join) {
                $join->on('d.entity_id', '=', 'n.nid')
                    ->where('d.entity_type', '=', 'node')
                    ->where('d.bundle', '=', 'curiosit_')
                    ->where('d.deleted', '=', 0)
                    ->where('d.delta', '=', 0);
            })
            ->where('n.type', 'curiosit_')
            ->orderBy('n.nid')
            ->select([
                'n.nid',
                'n.title',
                'n.status as drupal_status',
                'b.body_value',
                'b.body_summary',
                'd.field_date_value',
            ]);

        if ($limit = $this->option('limit')) {
            $query->limit((int) $limit);
        }

        $rows = $query->get();
        $imported = 0;
        $errors = 0;

        foreach ($rows as $row) {
            try {
                $payload = [
                    'title' => $row->title,
                    'slug' => Str::slug($row->title).'-'.$row->nid,
                    'excerpt' => $row->body_summary ?: null,
                    'content' => $row->body_value,
                    'published_at' => $row->field_date_value,
                    'is_published' => (bool) $row->drupal_status,
                ];

                if (! $this->option('dry-run')) {
                    Article::updateOrCreate(
                        ['legacy_drupal_id' => $row->nid],
                        $payload,
                    );
                }

                $imported++;
            } catch (\Throwable $exception) {
                $errors++;
                $this->error("Drupal nid {$row->nid}: {$exception->getMessage()}");
            }
        }

        $mode = $this->option('dry-run') ? 'DRY RUN' : 'IMPORT';
        $this->newLine();
        $this->info("{$mode} completato: {$imported} record elaborati, {$errors} errori.");

        if (! $this->option('dry-run')) {
            $targetCount = Article::whereNotNull('legacy_drupal_id')->count();
            $this->info("Articoli Laravel con legacy_drupal_id: {$targetCount}");
        }

        return $errors === 0 ? self::SUCCESS : self::FAILURE;
    }
}
