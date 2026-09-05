<?php

namespace App\Console\Commands;

use App\Models\Video;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportDrupalVideos extends Command
{
    protected $signature = 'ring:import-videos {--dry-run : Analizza senza scrivere nel nuovo database}';

    protected $description = 'Estrae e normalizza i video YouTube dal Drupal 7';

    private const VIDEO_PAGE_NID = 37;
    private const EXPECTED_VIDEOS = 13;

    public function handle(): int
    {
        $legacy = DB::connection('legacy_drupal');

        $body = $legacy->table('field_data_body')
            ->where('entity_type', 'node')
            ->where('entity_id', self::VIDEO_PAGE_NID)
            ->where('deleted', 0)
            ->where('delta', 0)
            ->value('body_value');

        if (! $body) {
            $this->error('Body della pagina Video Drupal non trovato (nid '.self::VIDEO_PAGE_NID.').');
            return self::FAILURE;
        }

        $ids = $this->extractYouTubeIds($body);

        $this->info('Video YouTube unici trovati: '.count($ids));

        if (count($ids) !== self::EXPECTED_VIDEOS) {
            $this->warn('Gate audit video: attesi '.self::EXPECTED_VIDEOS.' video.');
        }

        $errors = 0;

        foreach ($ids as $index => $youtubeId) {
            try {
                if (! $this->option('dry-run')) {
                    Video::updateOrCreate(
                        ['youtube_id' => $youtubeId],
                        [
                            'title' => 'Video '.str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT),
                            'thumbnail' => 'https://i.ytimg.com/vi/'.$youtubeId.'/hqdefault.jpg',
                            'is_published' => true,
                            'sort_order' => $index,
                        ],
                    );
                }

                $this->line(($index + 1).'. '.$youtubeId);
            } catch (\Throwable $exception) {
                $errors++;
                $this->error("YouTube {$youtubeId}: {$exception->getMessage()}");
            }
        }

        $mode = $this->option('dry-run') ? 'DRY RUN' : 'IMPORT';
        $this->newLine();
        $this->info("{$mode} video completato: ".count($ids)." video, {$errors} errori.");

        if (! $this->option('dry-run')) {
            $this->info('Video Laravel totali: '.Video::count());
        }

        return $errors === 0 ? self::SUCCESS : self::FAILURE;
    }

    /** @return list<string> */
    private function extractYouTubeIds(string $html): array
    {
        $patterns = [
            '~youtube(?:-nocookie)?\.com/embed/([A-Za-z0-9_-]{6,})~i',
            '~youtube\.com/watch\?[^"\'\s>]*v=([A-Za-z0-9_-]{6,})~i',
            '~youtu\.be/([A-Za-z0-9_-]{6,})~i',
        ];

        $ids = [];

        foreach ($patterns as $pattern) {
            preg_match_all($pattern, $html, $matches);

            foreach ($matches[1] ?? [] as $id) {
                $ids[] = $id;
            }
        }

        return array_values(array_unique($ids));
    }
}
