<?php

declare(strict_types = 1);

namespace App\Console\Commands\User;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

final class TestMemoryRunCommand extends Command
{
    protected $signature = 'user:test-memory-run
        {method : all|newQuery|toBase|dbTable|cursor|chunk|lazy|chunkById|pluck|cursorPaginate}
        {--count= : Limite de linhas a serem lidas}
        {--chunk=1000 : Tamanho do chunk para o método chunk}';

    protected $description = 'Executa uma query isolada e mede tempo e pico de memória real';

    public function handle(): int
    {
        $method    = (string) $this->argument('method');
        $countOpt  = $this->option('count');
        $chunkSize = (int) ($this->option('chunk') ?? 1000);
        $limit     = null !== $countOpt && '' !== $countOpt ? (int) $countOpt : null;

        DB::connection()->disableQueryLog();
        gc_collect_cycles();

        $beforeMem = memory_get_usage(false);
        $startTime = microtime(true);

        $rows   = 0;
        $result = null;

        switch ($method) {
            case 'all':
                $q = User::query();

                if ($limit) {
                    $q->take($limit);
                }
                $result = $q->get();
                $rows   = $result->count();

                break;

            case 'newQuery':
                $q = (new User())->newQuery()->select('id', 'name', 'email');

                if ($limit) {
                    $q->take($limit);
                }
                $result = $q->get();
                $rows   = $result->count();

                break;

            case 'toBase':
                $q = User::query()->select('id', 'name', 'email')->toBase();

                if ($limit) {
                    $q->limit($limit);
                }
                $result = $q->get();
                $rows   = count($result);

                break;

            case 'dbTable':
                $q = DB::table('users')->select('id', 'name', 'email');

                if ($limit) {
                    $q->limit($limit);
                }
                $result = $q->get();
                $rows   = count($result);

                break;

            case 'cursor':
                $q = User::query()->select('id', 'name', 'email');

                if ($limit) {
                    $q->limit($limit);
                }

                foreach ($q->cursor() as $_) {
                    ++$rows;
                }

                break;

            case 'chunk':
                $q = User::query()->select('id', 'name', 'email');

                if ($limit) {
                    $q->limit($limit);
                }
                $q->chunk(max(1, $chunkSize), function ($chunk) use (&$rows) { $rows += $chunk->count(); });

                break;

            case 'lazy':
                $q = User::query()->select('id', 'name', 'email');

                if ($limit) {
                    $q->limit($limit);
                }

                foreach ($q->lazy($chunkSize) as $_) {
                    ++$rows;
                }

                break;

            case 'chunkById':
                $q = User::query()->select('id', 'name', 'email');

                if ($limit) {
                    $q->limit($limit);
                }
                $q->chunkById($chunkSize, function ($chunk) use (&$rows) { $rows += $chunk->count(); });

                break;

            case 'pluck':
                $q = User::query();

                if ($limit) {
                    $q->take($limit);
                }
                $result = $q->pluck('email');
                $rows   = count($result);

                break;

            case 'cursorPaginate':
                $q = User::query()->select('id', 'name', 'email');

                if ($limit) {
                    $q->limit($limit);
                }
                $page = 1;

                do {
                    $paginator = $q->cursorPaginate($chunkSize, ['*'], 'page', $page);
                    $rows += $paginator->count();
                    ++$page;
                } while ($paginator->hasMorePages());

                break;

            default:
                $this->error('Método inválido.');

                return 1;
        }

        $elapsed = microtime(true) - $startTime;
        $peakMem = memory_get_peak_usage(false) - $beforeMem;

        $this->line("Linhas processadas: {$rows}");
        $this->line('Tempo total: ' . number_format($elapsed, 4) . 's');
        $this->line('Pico de memória incremental (real): ' . number_format($peakMem / 1024 / 1024, 4) . ' MB');

        unset($result);
        gc_collect_cycles();

        return 0;
    }
}
