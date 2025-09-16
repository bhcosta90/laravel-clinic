<?php

declare(strict_types = 1);

namespace App\Services\Domain\Scheduling;

use App\Models\Procedure;
use App\Models\User;
use Illuminate\Support\Collection;

final readonly class DoctorSelector
{
    public function select(?int $doctorId, ?string $procedureCode, ?string $specialtyCode): Collection
    {
        $q = User::query()->where('is_doctor', true);

        if ($doctorId && 0 !== $doctorId) {
            $q->where('id', $doctorId);
        }

        if ($procedureCode && '0' !== $procedureCode) {
            $procedure = Procedure::query()->where('code', $procedureCode)->first();

            if ($procedure) {
                $linked = $procedure->doctors()->pluck('users.id')->all();

                if (!empty($linked)) {
                    $q->whereIn('id', $linked);
                }
            }
        }

        if ($specialtyCode && '0' !== $specialtyCode) {
            $q->whereHas('specialties', fn ($qq) => $qq->where('code', $specialtyCode));
        }

        return $q->get(['id', 'has_fixed_hours']);
    }
}
