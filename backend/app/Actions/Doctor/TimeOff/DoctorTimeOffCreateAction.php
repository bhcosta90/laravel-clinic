<?php

declare(strict_types=1);

namespace App\Actions\Doctor\TimeOff;

use App\Models\Doctor;
use App\Models\DoctorTimeOff;
use App\Query\Doctor\DoctorVerifyTimeOff;
use DateTimeInterface;
use Illuminate\Validation\ValidationException;

final readonly class DoctorTimeOffCreateAction
{
    public function __construct(private DoctorVerifyTimeOff $verifyTimeOff) {}

    public function execute(
        Doctor $doctor,
        DateTimeInterface $startAt,
        DateTimeInterface $endAt,
        ?string $reason = null,
    ): DoctorTimeOff {

        $existTimeOff = $this->verifyTimeOff->execute($doctor, $startAt, $endAt);

        if ($existTimeOff) {
            throw ValidationException::withMessages([
                'time_off' => ['The doctor already has a time off during this period.'],
            ]);
        }

        return $doctor->timeOff()->create([
            'start_at' => $startAt,
            'end_at' => $endAt,
            'reason' => $reason,
        ]);
    }
}
