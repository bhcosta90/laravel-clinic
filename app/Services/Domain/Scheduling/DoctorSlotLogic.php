<?php

declare(strict_types = 1);

// @codeCoverageIgnoreFile

namespace App\Services\Domain\Scheduling;

use Carbon\Carbon;
use Illuminate\Support\Collection;

final readonly class DoctorSlotLogic
{
    public function __construct(private TimeRounding $rounding, private Availability $availability)
    {
    }

    public function scanSchedules(Collection $daySchedules, Carbon $cursor, DoctorSlotRequest $req, int $doctorId, Carbon $effEnd, int $step): ?array
    {
        foreach ($daySchedules as $schedule) {
            $start = $cursor->copy()->setTimeFromTimeString($schedule->start_time);
            $end   = $cursor->copy()->setTimeFromTimeString($schedule->end_time);
            $eff   = $effEnd->lt($end) ? $effEnd->copy() : $end;
            $slot  = $this->scanWindow($cursor, $start, $eff, $step, $req, $doctorId);

            if (null !== $slot && [] !== $slot) {
                return $slot;
            }
        }

        return null;
    }

    private function scanWindow(Carbon $cursor, Carbon $start, Carbon $eff, int $step, DoctorSlotRequest $req, int $doctorId): ?array
    {
        $cand = $cursor->gt($start) ? $this->rounding->roundUpToSlot($start, $cursor, $step) : $start->copy();
        while ($cand->addMinutes(0)->lt($eff)) {
            $candEnd = $cand->copy()->addMinutes($req->duration);

            if ($candEnd->gt($eff)) {
                break;
            }

            if ($this->availability->isDoctorAvailable($req->doctorBlocksByDoc, $req->appointmentsByDoc, $doctorId, $cand, $candEnd) && !$this->availability->patientConflicts($req->patientAppointments, $cand, $candEnd)) {
                $maxEnd = $this->expandMaxEnd($cand, $eff, $step, $req, $doctorId);
                $roomId = null;

                if ($req->requireRoom || ($req->roomCode && '0' !== $req->roomCode)) {
                    $roomId = ($req->pickRoom)($cand, $candEnd);

                    if (null === $roomId) {
                        $cand->addMinutes($step);

                        continue;
                    }
                }

                return [
                    'doctor_id'        => $doctorId,
                    'room_id'          => $roomId,
                    'start_at'         => $cand->copy(),
                    'end_at'           => $candEnd,
                    'possible_end_min' => $cand->copy()->addMinutes($req->durationMin),
                    'possible_end_max' => $maxEnd,
                ];
            }
            $cand->addMinutes($step);
        }

        return null;
    }

    private function expandMaxEnd(Carbon $cand, Carbon $eff, int $step, DoctorSlotRequest $req, int $doctorId): Carbon
    {
        $maxEnd = $cand->copy()->addMinutes($req->durationMin);

        if ($req->procedureCode && '0' !== $req->procedureCode) {
            $target = $cand->copy()->addMinutes($req->durationMax);
            $maxAlw = $target->gt($eff) ? $eff->copy() : $target;
            $extend = $maxEnd->copy();
            while ($extend->lt($maxAlw)) {
                $nextEnd = $extend->copy()->addMinutes($step);

                if ($nextEnd->gt($maxAlw)) {
                    $nextEnd = $maxAlw->copy();
                }

                if ($this->availability->isDoctorAvailable($req->doctorBlocksByDoc, $req->appointmentsByDoc, $doctorId, $cand, $nextEnd)) {
                    $extend = $nextEnd;
                } else {
                    break;
                }
            }
            $maxEnd = $extend;
        }

        return $maxEnd;
    }
}
