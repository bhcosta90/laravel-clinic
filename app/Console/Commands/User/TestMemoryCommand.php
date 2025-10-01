<?php

declare(strict_types = 1);

namespace App\Console\Commands\User;

use Illuminate\Console\Command;

final class TestMemoryCommand extends Command
{
    protected $signature = 'user:test-memory';

    protected $description = 'Roda todos os testes de memória e tempo isoladamente';

    public function handle(): void
    {
        $tests = [
            'Eloquent all'        => 'php artisan user:test-memory-run all',
            'Eloquent newQuery'   => 'php artisan user:test-memory-run newQuery',
            'QueryBuilder toBase' => 'php artisan user:test-memory-run toBase',
            'DB::table'           => 'php artisan user:test-memory-run dbTable',
        ];

        foreach ($tests as $label => $cmd) {
            $this->info("Rodando teste: {$label}");
            $start  = microtime(true);
            $output = shell_exec($cmd);
            $time   = number_format(microtime(true) - $start, 4);
            $this->line($output);
            $this->line("Tempo total de execução (processo isolado): {$time}s\n");
        }

        $this->info('--- Fim do benchmark ---');
    }
}
