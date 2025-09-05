<?php

declare(strict_types = 1);

namespace App\Jobs\LocationModule;

use App\Enums\Models\Location\OrderColumn;
use App\Enums\Queue\Queue;
use App\Models\Location;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;

final class OrderColumnJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(public int $locationModuleId, public OrderColumn $type)
    {
        $this->onQueue(Queue::Low);
    }

    public function handle(): void
    {
        $query = app(BuilderQuery::class)->execute(new Location(), [
            '(location_module_id)' => $this->locationModuleId,
        ]);

        // Normalize type

        // Define ordering according to requested mode
        // Also consider level and position as tie-breakers
        match (true) {
            // Evens first (ASC), then odds (DESC within their group)
            // Use CASE expressions to apply different directions per parity
            OrderColumn::EvenOdd === $this->type => $query->orderByRaw('(`column` % 2) ASC')
                ->orderByRaw('CASE WHEN (`column` % 2) = 0 THEN `column` END ASC')
                ->orderByRaw('CASE WHEN (`column` % 2) = 1 THEN `column` END DESC'),
            // Odds first (ASC), then evens (DESC within their group)
            OrderColumn::OddEven === $this->type => $query->orderByRaw('(`column` % 2) DESC')
                ->orderByRaw('CASE WHEN (`column` % 2) = 1 THEN `column` END ASC')
                ->orderByRaw('CASE WHEN (`column` % 2) = 0 THEN `column` END DESC'),
            // Natural ascending sequence by column, then level and position
            default => $query->orderBy('column', 'ASC'),
        };

        $query->orderBy('level', 'ASC')
            ->orderBy('position', 'ASC')
            ->orderBy('id', 'ASC');

        // Apply the computed order into sequence field so that the picking route is persisted
        $sequence = 0;
        $query->chunkById(500, function ($locations) use (&$sequence): void {
            foreach ($locations as $loc) {
                // Update only if different to minimize writes
                if ($loc->sequence !== $sequence) {
                    $loc->sequence = $sequence;
                    $loc->save();
                }
                ++$sequence;
            }
        }, 'id');

        $query->update([
            'sequence' => DB::raw('`sequence` * 10'),
        ]);
    }
}
