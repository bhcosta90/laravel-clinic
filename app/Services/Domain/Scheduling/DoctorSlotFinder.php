<?php

declare(strict_types = 1);

// @codeCoverageIgnoreFile

namespace App\Services\Domain\Scheduling;

use Illuminate\Support\Collection;

final readonly class DoctorSlotFinder
{
    public function __construct(private DoctorSlotLogic $logic)
    {
    }

    public function find(DoctorSlotRequest $req): Collection
    {
        $slots = collect();

        $doctors = $req->doctors;

        foreach ($doctors as $doctor) {
            $schedules = ($req->getSchedulesByDoctor)($doctor->id);

            if ($schedules->isEmpty() && $doctor->has_fixed_hours) {
                $schedules = $req->clinicSchedules->isNotEmpty() ? $req->clinicSchedules : $this->defaultWeek();
            }
            $cursor = $req->minDate->copy();
            while ($cursor->lt($req->endSearch)) {
                if (!($req->insurerAllows)($cursor)) {
                    $cursor->addDay()->startOfDay();

                    continue;
                }
                $dow = $cursor->dayOfWeek;
                $day = $schedules->get($dow, collect());

                if ($day->isNotEmpty()) {
                    foreach ($day as $schedule) {
                        $step = (int) $schedule->slot_minutes;
                        $slot = $this->logic->scanSchedules(collect([$schedule]), $cursor, $req, $doctor->id, $req->endSearch, $step);

                        if (null !== $slot && [] !== $slot) {
                            $slots->push($slot);

                            if ($req->maxSlots && $slots->count() >= $req->maxSlots) {
                                return $slots;
                            }

                            break 2;
                        }
                    }
                }
                $cursor->addDay()->startOfDay();
            }
        }

        return $slots;
    }

    private function defaultWeek(): Collection
    {
        return collect([1, 2, 3, 4, 5])->mapWithKeys(fn ($dow): array => [$dow => collect([(object) ['start_time' => '09:00:00', 'end_time' => '17:00:00', 'slot_minutes' => 30]])]);
    }
}
