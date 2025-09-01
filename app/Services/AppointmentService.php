<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Appointment;
use Illuminate\Support\Carbon;

final class AppointmentService extends Service
{
    /**
     * Returns how many appointments the given user has scheduled within a time window.
     *
     * Original behavior: given a single $date, checks the slot [$date, $date + interval_minutes).
     * New behavior: if $end is provided, checks overlap within [$start, $end).
     *
     * We consider minutes precision (ignore seconds) to avoid mismatch by seconds.
     */
    public function verifyQuantityScheduleFromUser(int $userId, Carbon $start, ?Carbon $end = null): int
    {
        $start = $start->copy()->seconds(0);
        $end   = ($end?->copy() ?? $start->copy()->addMinutes(config('date.interval_minutes')))->seconds(0);

        // Ensure chronological order
        if ($end->lessThan($start)) {
            [$start, $end] = [$end, $start];
        }

        // We assume each appointment occupies a slot starting at `date` with length = interval_minutes.
        // We want to count any appointment whose slot overlaps with [$start, $end).
        $slotMinutes = (int) config('date.interval_minutes');

        return Appointment::query()
            ->where('user_id', $userId)
            ->where(function ($q) use ($start, $end, $slotMinutes): void {
                // Overlap condition (DB-agnostic):
                // appointmentStart < end AND appointmentStart > (start - slotMinutes)
                $q->where('date', '<', $end)
                    ->where('date', '>', $start->copy()->subMinutes($slotMinutes));
            })
            ->count();
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
