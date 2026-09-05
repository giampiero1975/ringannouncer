<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Event;
use App\Models\Page;
use App\Models\Redirect;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportDrupalRedirects extends Command
{
    protected $signature = 'ring:import-redirects {--dry-run : Analizza senza scrivere nel nuovo database}';

    protected $description = 'Genera i redirect SEO dai nodi Drupal agli URL Laravel';

    private const EXPECTED_NODE_COUNT = 577;

    public function handle(): int
    {
        $legacy = DB::connection('legacy_drupal');

        $nodes = $legacy->table('node')
            ->whereIn('type', ['portfolio', 'curiosit_', 'page', 'gallery'])
            ->orderBy('nid')
            ->get(['nid', 'type', 'title']);

        $this->info('Nodi Drupal candidati ai redirect: '.$nodes->count());

        if ($nodes->count() !== self::EXPECTED_NODE_COUNT) {
            $this->warn('Gate audit: attesi '.self::EXPECTED_NODE_COUNT.' nodi. Verificare il dump.');
        }

        $processed = 0;
        $errors = 0;

        foreach ($nodes as $node) {
            try {
                $newPath = $this->resolveNewPath($node);

                if ($newPath === null) {
                    $this->warn("nid {$node->nid}: target non risolto");
                    $errors++;
                    continue;
                }

                $oldPath = '/node/'.$node->nid;

                if (! $this->option('dry-run')) {
                    Redirect::updateOrCreate(
                        ['old_path' => $oldPath],
                        [
                            'new_path' => $newPath,
                            'status_code' => 301,
                        ],
                    );
                }

                $processed++;
            } catch (\Throwable $exception) {
                $errors++;
                $this->error("Drupal nid {$node->nid}: {$exception->getMessage()}");
            }
        }

        $aliases = $legacy->table('url_alias')
            ->where('source', 'like', 'node/%')
            ->get(['source', 'alias']);

        $aliasAdded = 0;

        foreach ($aliases as $alias) {
            $nid = (int) Str::after($alias->source, 'node/');
            $node = $nodes->firstWhere('nid', $nid);

            if (! $node) {
                continue;
            }

            $newPath = $this->resolveNewPath($node);
            $oldPath = '/'.ltrim($alias->alias, '/');

            if ($newPath === null || $oldPath === $newPath) {
                continue;
            }

            if (! $this->option('dry-run')) {
                Redirect::updateOrCreate(
                    ['old_path' => $oldPath],
                    [
                        'new_path' => $newPath,
                        'status_code' => 301,
                    ],
                );
            }

            $aliasAdded++;
        }

        $mode = $this->option('dry-run') ? 'DRY RUN' : 'IMPORT';
        $this->newLine();
        $this->info("{$mode} redirect completato: {$processed} node redirect, {$aliasAdded} alias aggiuntivi, {$errors} errori.");

        if (! $this->option('dry-run')) {
            $this->info('Redirect Laravel totali: '.Redirect::count());
        }

        return $errors === 0 ? self::SUCCESS : self::FAILURE;
    }

    private function resolveNewPath(object $node): ?string
    {
        return match ($node->type) {
            'portfolio' => $this->eventPath((int) $node->nid, $node->title),
            'curiosit_' => $this->articlePath((int) $node->nid, $node->title),
            'page' => $this->pagePath((int) $node->nid, $node->title),
            'gallery' => '/gallery/'.Str::slug($node->title).'-'.$node->nid,
            default => null,
        };
    }

    private function eventPath(int $nid, string $title): string
    {
        $event = Event::where('legacy_drupal_id', $nid)->first();

        return '/eventi/'.($event?->slug ?? Str::slug($title).'-'.$nid);
    }

    private function articlePath(int $nid, string $title): string
    {
        $article = Article::where('legacy_drupal_id', $nid)->first();

        return '/curiosita/'.($article?->slug ?? Str::slug($title).'-'.$nid);
    }

    private function pagePath(int $nid, string $title): string
    {
        return match ($nid) {
            1 => '/',
            2 => '/chi-sono',
            default => '/pagine/'.Str::slug($title).'-'.$nid,
        };
    }
}
