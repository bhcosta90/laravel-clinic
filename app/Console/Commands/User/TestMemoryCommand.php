<?php

declare(strict_types = 1);

namespace App\Console\Commands\User;

use Illuminate\Console\Command;

final class TestMemoryCommand extends Command
{
    protected $signature = 'user:test-memory
        {--count= : Limite de linhas a serem lidas}
        {--chunk=1000 : Tamanho do chunk para o método chunk}';

    protected $description = 'Roda todos os testes de memória e tempo em processos isolados e exibe tabela';

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

        $results = [];

        foreach ($tests as $label => $method) {
            $this->info("Rodando teste: {$label}");
            $cmd    = sprintf('php artisan user:test-memory-run %s %s', $method, $optStr);
            $start  = microtime(true);
            $output = shell_exec($cmd);
            $time   = number_format(microtime(true) - $start, 4);

            $rows = null;
            $peak = null;

            if ($output) {
                // Extrai Linhas e Pico de Memória da saída
                preg_match('/Linhas processadas: (\d+)/', $output, $m1);
                preg_match('/Pico de memória incremental.*: ([\d\.]+) MB/', $output, $m2);
                $rows = $m1[1] ?? null;
                $peak = $m2[1] ?? null;
            }

            $results[] = [
                'Método'            => $label,
                'Linhas'            => $rows ?? '-',
                'Tempo (s)'         => $time,
                'Pico memória (MB)' => $peak ?? '-',
            ];
        }

        $this->info('--- Resultados finais ---');
        $this->table(
            ['Método', 'Linhas', 'Tempo (s)', 'Pico memória (MB)'],
            $results
        );
    }
}
