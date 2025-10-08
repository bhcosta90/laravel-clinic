<?php

declare(strict_types=1);

namespace App\Query\Doctor;

use App\Models\Doctor;
use DateTimeInterface;

final class DoctorVerifyTimeOff
{
    public function execute(
        Doctor $doctor,
        DateTimeInterface $startAt,
        DateTimeInterface $endAt,
        ?int $id,
    ): bool {
        return $doctor->timeOff()->where(function ($query) use ($startAt, $endAt) {
            $query->whereBetween('start_at', [$startAt, $endAt])
                ->orWhereBetween('end_at', [$startAt, $endAt])
                ->orWhere(function ($q) use ($startAt, $endAt) {
                    $q->where('start_at', '<', $startAt)
                        ->where('end_at', '>', $endAt);
                });
        })
            ->when($id, fn ($query) => $query->where('id', '!=', $id))
            ->exists();
    }
}
