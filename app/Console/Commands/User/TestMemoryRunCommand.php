<?php

declare(strict_types = 1);

namespace App\Console\Commands\User;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

final class TestMemoryRunCommand extends Command
{
    protected $signature = 'user:test-memory-run {method}';

    protected $description = 'Executa uma query isolada e mede pico de memória real';

    public function handle(): void
    {
        $method = $this->argument('method');

        $beforeMem = memory_get_usage();

        switch ($method) {
            case 'all':
                $result = User::all();

                break;

            case 'newQuery':
                $result = (new User())->newQuery()->select('id', 'name', 'email')->get();

                break;

            case 'toBase':
                $result = User::query()->select('id', 'name', 'email')->toBase()->get();

                break;

            case 'dbTable':
                $result = DB::table('users')->select('id', 'name', 'email')->get();

                break;

            default:
                $this->error('Método inválido');

                return;
        }

        $peakMem = memory_get_peak_usage() - $beforeMem;
        $this->line('Pico de memória incremental desta query: ' . number_format($peakMem / 1024 / 1024, 4) . ' MB');

        unset($result);
        gc_collect_cycles();
    }
}
