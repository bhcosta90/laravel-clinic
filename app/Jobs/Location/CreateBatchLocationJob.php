<?php

declare(strict_types = 1);

namespace App\Jobs\Location;

use App\Enums\Queue\Queue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class CreateBatchLocationJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public int $last,
        public array $data,
    ) {
        $this->onQueue(Queue::Low);
    }

    public function handle(): void
    {
        $data  = $this->data;
        $total = $this->last - 1;
        $job   = collect();

        for ($i = $data['column_initial']; $i <= $data['column_final']; ++$i) {
            for ($j = $data['level_initial']; $j <= $data['level_final']; ++$j) {
                for ($k = $data['position_initial']; $k <= $data['position_final']; ++$k) {
                    $job->push(new CreateNewLocationJob(
                        $data['sector_id'],
                        $data['location_module_id'],
                        $data['type'],
                        (int) $i,
                        (int) $j,
                        (int) $k,
                        $data['zone'],
                        $data['max_capacity'] ?? null,
                        $total,
                        $data['control'] ?? null,
                        $data['temperature'] ?? null,
                        $data['status'],
                    ));

                    $total += 10;
                }
            }
        }

        dispatch($job->pop());

        $job->map(fn ($job) => dispatch($job)->delay(now()->between(now()->addSeconds(0), now()->addSeconds(60))));
    }
}
