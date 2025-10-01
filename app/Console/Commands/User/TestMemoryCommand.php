<?php

declare(strict_types = 1);

namespace App\Console\Commands\User;

use Illuminate\Console\Command;

final class TestMemoryCommand extends Command
{
    protected $signature = 'user:test-memory {--count= : Limite de linhas a serem lidas} {--chunk=1000 : Tamanho do chunk para o método chunk}';

    protected $description = 'Roda todos os testes de memória e tempo em processos isolados';

    public function handle(): void
    {
        $countOpt  = $this->option('count');
        $chunkSize = $this->option('chunk');
        $opts      = [];

        if (null !== $countOpt && '' !== $countOpt) {
            $opts[] = '--count=' . (int) $countOpt;
        }

        if (null !== $chunkSize && '' !== $chunkSize) {
            $opts[] = '--chunk=' . (int) $chunkSize;
        }
        $optStr = implode(' ', $opts);

        $tests = [
            'Eloquent all'        => 'all',
            'Eloquent newQuery'   => 'newQuery',
            'QueryBuilder toBase' => 'toBase',
            'DB::table'           => 'dbTable',
            'Eloquent cursor'     => 'cursor',
            'Eloquent chunk'      => 'chunk',
        ];

        foreach ($tests as $label => $method) {
            $this->info("Rodando teste: {$label}");
            $cmd    = sprintf('php artisan user:test-memory-run %s %s', $method, $optStr);
            $start  = microtime(true);
            $output = shell_exec($cmd);
            $time   = number_format(microtime(true) - $start, 4);
            $this->line($output ?? '');
            $this->line("Tempo total de execução (processo isolado): {$time}s\n");
        }

        $this->info('--- Fim do benchmark ---');
    }
}
