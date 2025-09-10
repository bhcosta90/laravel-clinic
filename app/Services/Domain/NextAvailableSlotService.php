<?php

declare(strict_types = 1);

// @codeCoverageIgnoreFile

namespace App\Services\Domain;

use App\Models\UserSchedule;
use Carbon\Carbon;
use Illuminate\Support\Collection;

final readonly class NextAvailableSlotService
{
    private Scheduling\TimeRounding $rounding;

    public function __construct(?Scheduling\TimeRounding $rounding = null)
    {
        $this->rounding = $rounding ?? app(Scheduling\TimeRounding::class);
    }

    /**
     * Get the next available slot for a user's schedule.
     * - If called on a working day during working hours, rounds up to the next slot boundary.
     * - If called outside working hours or on a non-working day, returns the next working day's start slot.
     */
    public function getNextAvailable(int $userId, ?Carbon $from = null): ?Carbon
    {
        $now = $from?->copy() ?? now();

        // Fetch schedules for the user
        /** @var Collection<int, UserSchedule> $schedules */
        $schedules = UserSchedule::query()
            ->where('user_id', $userId)
            ->orderBy('day_of_week')
            ->get();

        if ($schedules->isEmpty()) {
            return null;
        }

        // Search for up to 14 days ahead to find the next slot
        for ($i = 0; $i < 14; ++$i) {
            $current = $now->copy()->addDays($i);
            $dow     = (int) $current->dayOfWeek; // 0..6

            $daySchedules = $schedules->where('day_of_week', $dow);

            if ($daySchedules->isEmpty()) {
                continue;
            }

            foreach ($daySchedules as $schedule) {
                $start = $current->copy()->setTimeFromTimeString($schedule->start_time);
                $end   = $current->copy()->setTimeFromTimeString($schedule->end_time);

                // Determine candidate time on this day
                $candidate = 0 === $i ? $this->roundUpToBoundary($start, $now, (int) $schedule->slot_minutes) : $start->copy();

                // If the search date is beyond end, skip
                if ($candidate->lt($start)) {
                    $candidate = $start->copy();
                }

                if ($candidate->gte($end)) {
                    continue; // no time left in this schedule today
                }

                // Ensure candidate is aligned to slot boundary and within the window
                $candidate = $this->roundUpToBoundary($start, $candidate, (int) $schedule->slot_minutes);

                if ($candidate->lt($end)) {
                    return $candidate;
                }
            }
        }

        return null;
    }

    private function roundUpToBoundary(Carbon $maxTime, Carbon $now, int $slotMinutes): Carbon
    {
        return $this->rounding->roundUpToSlot($maxTime, $now, $slotMinutes);
    }
}
