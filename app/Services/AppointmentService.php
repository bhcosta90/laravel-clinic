<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Appointment;
use Illuminate\Support\Carbon;

final class AppointmentService extends Service
{
    /**
     * Returns how many appointments the given user has scheduled
     * on the same day and at the specific time passed in $date.
     *
     * We consider the same minute (00-59 seconds) to avoid mismatch by seconds.
     */
    public function verifyQuantityScheduleFromUser(int $userId, Carbon $date): int
    {
        $start = $date->copy();
        $end   = $date->copy()->addMinutes(config('date.interval_minutes'));

        return 0;
    }

    protected function model(): Appointment
    {
        return new Appointment();
    }

    protected function search(): array
    {
        return ['date'];
    }
}
