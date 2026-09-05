<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportDrupalPortfolio extends Command
{
    protected $signature = 'ring:import-portfolio {--dry-run : Analizza senza scrivere nel nuovo database} {--limit= : Limita il numero di record per i test}';

    protected $description = 'Importa il Portfolio Drupal 7 negli eventi RingAnnouncer';

    private const EXPECTED_SOURCE_COUNT = 493;

    private const WEIGHT_CATEGORIES = [
        '1' => 'Paglia',
        '2' => 'Mosca leggeri',
        '3' => 'Mosca',
        '4' => 'Supermosca (Gallo jr.)',
        '5' => 'Gallo',
        '6' => 'Supergallo (Piuma jr.)',
        '7' => 'Piuma',
        '8' => 'Superpiuma (Leggeri jr.)',
        '9' => 'Leggeri',
        '10' => 'Superleggeri (Welter jr., Welter leggeri)',
        '11' => 'Welter',
        '12' => 'Superwelter (Medi jr., Medi leggeri)',
        '13' => 'Medi',
        '14' => 'Supermedi',
        '15' => 'Mediomassimi',
        '16' => 'Massimi leggeri (Cruiser)',
        '17' => 'Massimi',
    ];

    public function handle(): int
    {
        $legacy = DB::connection('legacy_drupal');

        $sourceCount = $legacy->table('node')
            ->where('type', 'portfolio')
            ->count();

        $this->info("Portfolio Drupal trovati: {$sourceCount}");

        if ($sourceCount !== self::EXPECTED_SOURCE_COUNT) {
            $this->warn('Gate audit: attesi '.self::EXPECTED_SOURCE_COUNT.' record. Verificare il dump prima del go-live.');
        }

        $query = $legacy->table('node as n')
            ->leftJoin('field_data_body as b', function ($join) {
                $join->on('b.entity_id', '=', 'n.nid')
                    ->where('b.entity_type', '=', 'node')
                    ->where('b.bundle', '=', 'portfolio')
                    ->where('b.deleted', '=', 0)
                    ->where('b.delta', '=', 0);
            })
            ->leftJoin('field_data_field_event_date as d', function ($join) {
                $join->on('d.entity_id', '=', 'n.nid')
                    ->where('d.entity_type', '=', 'node')
                    ->where('d.bundle', '=', 'portfolio')
                    ->where('d.deleted', '=', 0)
                    ->where('d.delta', '=', 0);
            })
            ->leftJoin('field_data_field_categoria as c', function ($join) {
                $join->on('c.entity_id', '=', 'n.nid')
                    ->where('c.entity_type', '=', 'node')
                    ->where('c.bundle', '=', 'portfolio')
                    ->where('c.deleted', '=', 0)
                    ->where('c.delta', '=', 0);
            })
            ->where('n.type', 'portfolio')
            ->orderBy('n.nid')
            ->select([
                'n.nid',
                'n.title',
                'n.status as drupal_status',
                'b.body_value',
                'd.field_event_date_value',
                'd.field_event_date_value2',
                'c.field_categoria_value',
            ]);

        if ($limit = $this->option('limit')) {
            $query->limit((int) $limit);
        }

        $rows = $query->get();
        $imported = 0;
        $errors = 0;

        foreach ($rows as $row) {
            try {
                $eventDate = $row->field_event_date_value;
                $status = $eventDate && $eventDate > now()->format('Y-m-d H:i:s')
                    ? 'scheduled'
                    : 'completed';

                $payload = [
                    'title' => $row->title,
                    'slug' => Str::slug($row->title).'-'.$row->nid,
                    'description' => $row->body_value,
                    'event_date' => $eventDate,
                    'event_end_date' => $row->field_event_date_value2,
                    'status' => $status,
                    'weight_category' => self::WEIGHT_CATEGORIES[(string) $row->field_categoria_value] ?? null,
                    'is_published' => (bool) $row->drupal_status,
                ];

                if (! $this->option('dry-run')) {
                    Event::updateOrCreate(
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
            $targetCount = Event::whereNotNull('legacy_drupal_id')->count();
            $this->info("Eventi Laravel con legacy_drupal_id: {$targetCount}");
        }

        return $errors === 0 ? self::SUCCESS : self::FAILURE;
    }
}
