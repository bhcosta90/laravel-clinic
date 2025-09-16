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
        $candidate = $cursor->gt($start) ? $this->rounding->roundUpToSlot($start, $cursor, $step) : $start->copy();
        while ($candidate->addMinutes(0)->lt($eff)) {
            $candidateEnd = $candidate->copy()->addMinutes($req->duration);

            if ($candidateEnd->gt($eff)) {
                break;
            }

            if ($this->availability->isDoctorAvailable($req->doctorBlocksByDoc, $req->appointmentsByDoc, $doctorId, $candidate, $candidateEnd) && !$this->availability->patientConflicts($req->patientAppointments, $candidate, $candidateEnd)) {
                $maxEnd = $this->expandMaxEnd($candidate, $eff, $step, $req, $doctorId);
                $roomId = null;

                if ($req->requireRoom || ($req->roomCode && '0' !== $req->roomCode)) {
                    $roomId = ($req->pickRoom)($candidate, $candidateEnd);

                    if (null === $roomId) {
                        $candidate->addMinutes($step);

                        continue;
                    }
                }

                return [
                    'doctor_id'        => $doctorId,
                    'room_id'          => $roomId,
                    'start_at'         => $candidate->copy(),
                    'end_at'           => $candidateEnd,
                    'possible_end_min' => $candidate->copy()->addMinutes($req->durationMin),
                    'possible_end_max' => $maxEnd,
                ];
            }
            $candidate->addMinutes($step);
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
