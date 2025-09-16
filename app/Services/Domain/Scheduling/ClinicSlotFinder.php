<?php

declare(strict_types = 1);

// @codeCoverageIgnoreFile

namespace App\Services\Domain\Scheduling;

use Carbon\Carbon;
use Illuminate\Support\Collection;

final readonly class ClinicSlotFinder
{
    public function __construct(private TimeRounding $rounding, private Availability $availability)
    {
    }

    /**
     * @param Collection $clinicSchedules grouped by day_of_week
     */
    public function find(Collection $clinicSchedules, Carbon $minDate, Carbon $endSearch, int $defaultMinutes, bool $requireRoom, ?string $roomCode, ?int $maxSlots, callable $pickRoom): Collection
    {
        $slots = collect();

        if ($clinicSchedules->isEmpty()) {
            return $slots;
        }
        $cursor = $minDate->copy();
        while ($cursor->lt($endSearch)) {
            $dow   = (int) $cursor->dayOfWeek;
            $sched = $clinicSchedules->get($dow, collect());

            foreach ($sched as $schedule) {
                $start = $cursor->copy()->setTimeFromTimeString($schedule->start_time);
                $end   = $cursor->copy()->setTimeFromTimeString($schedule->end_time);
                $eff   = $endSearch->lt($end) ? $endSearch->copy() : $end;
                $step  = (int) $schedule->slot_minutes;
                $cand  = $cursor->gt($start) ? $this->rounding->roundUpToSlot($start, $cursor, $step) : $start->copy();
                while ($cand->lt($eff)) {
                    $candEnd = $cand->copy()->addMinutes($defaultMinutes);

                    if ($candEnd->gt($eff)) {
                        break;
                    }

                    if (!$this->availability->isClinicBlocked(collect(), $cand, $candEnd)) {
                        $roomId = null;

                        if ($requireRoom || (null !== $roomCode && '' !== $roomCode && '0' !== $roomCode)) {
                            $roomId = $pickRoom($cand, $candEnd);

                            if (null === $roomId) {
                                $cand->addMinutes($step);

                                continue;
                            }
                        }
                        $slots->push([
                            'doctor_id'        => null,
                            'room_id'          => $roomId,
                            'start_at'         => $cand->copy(),
                            'end_at'           => $candEnd,
                            'possible_end_min' => $candEnd->copy(),
                            'possible_end_max' => $candEnd->copy(),
                        ]);

                        if ($maxSlots && $slots->count() >= $maxSlots) {
                            return $slots;
                        }

                        break 2;
                    }
                    $cand->addMinutes($step);
                }
            }
            $cursor->addDay()->startOfDay();
        }

        return $slots;
    }
}
