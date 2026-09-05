<?php

namespace App\Console\Commands;

use App\Models\Page;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportDrupalPages extends Command
{
    protected $signature = 'ring:import-pages {--dry-run : Analizza senza scrivere nel nuovo database}';

    protected $description = 'Importa le pagine statiche Drupal 7 in RingAnnouncer';

    private const EXPECTED_SOURCE_COUNT = 3;

    public function handle(): int
    {
        $legacy = DB::connection('legacy_drupal');

        $sourceCount = $legacy->table('node')
            ->where('type', 'page')
            ->count();

        $this->info("Pagine Drupal trovate: {$sourceCount}");

        if ($sourceCount !== self::EXPECTED_SOURCE_COUNT) {
            $this->warn('Gate audit: attese '.self::EXPECTED_SOURCE_COUNT.' pagine. Verificare il dump.');
        }

        $rows = $legacy->table('node as n')
            ->leftJoin('field_data_body as b', function ($join) {
                $join->on('b.entity_id', '=', 'n.nid')
                    ->where('b.entity_type', '=', 'node')
                    ->where('b.bundle', '=', 'page')
                    ->where('b.deleted', '=', 0)
                    ->where('b.delta', '=', 0);
            })
            ->where('n.type', 'page')
            ->orderBy('n.nid')
            ->select([
                'n.nid',
                'n.title',
                'n.status as drupal_status',
                'b.body_value',
            ])
            ->get();

        $processed = 0;
        $errors = 0;

        foreach ($rows as $row) {
            try {
                $key = match ((int) $row->nid) {
                    1 => 'home',
                    2 => 'chi-sono',
                    default => Str::slug($row->title).'-'.$row->nid,
                };

                if (! $this->option('dry-run')) {
                    Page::updateOrCreate(
                        ['legacy_drupal_id' => $row->nid],
                        [
                            'key' => $key,
                            'title' => $row->title,
                            'content' => $row->body_value,
                            'is_published' => (bool) $row->drupal_status,
                        ],
                    );
                }

                $this->line("nid {$row->nid} -> {$key} | {$row->title}");
                $processed++;
            } catch (\Throwable $exception) {
                $errors++;
                $this->error("Drupal nid {$row->nid}: {$exception->getMessage()}");
            }
        }

        $mode = $this->option('dry-run') ? 'DRY RUN' : 'IMPORT';
        $this->newLine();
        $this->info("{$mode} pagine completato: {$processed} elaborate, {$errors} errori.");

        if (! $this->option('dry-run')) {
            $targetCount = Page::whereNotNull('legacy_drupal_id')->count();
            $this->info("Pagine Laravel con legacy_drupal_id: {$targetCount}");
        }

        return $errors === 0 ? self::SUCCESS : self::FAILURE;
    }
}
