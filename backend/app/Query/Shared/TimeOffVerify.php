<?php

declare(strict_types=1);

namespace App\Query\Shared;

use App\Models\Doctor;
use App\Models\Room;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;

final class TimeOffVerify
{
    public function execute(
        Doctor|Room $doctor,
        DateTimeInterface $startAt,
        DateTimeInterface $endAt,
        ?int $id = null,
    ): bool {
        return $doctor->timeOff()->where(function (Builder $query) use ($startAt, $endAt): void {
            $query->whereBetween('start_at', [$startAt, $endAt])
                ->orWhereBetween('end_at', [$startAt, $endAt])
                ->orWhere(function (Builder $q) use ($startAt, $endAt): void {
                    $q->where('start_at', '<', $startAt)
                        ->where('end_at', '>', $endAt);
                });
        })
            ->when($id, fn (Builder $query) => $query->where('id', '!=', $id))->exists();
    }
}
