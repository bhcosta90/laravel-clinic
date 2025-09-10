<?php

declare(strict_types = 1);

namespace App\Services\Domain\Scheduling;

use App\Models\Appointment;
use App\Models\Room;
use App\Models\UserSchedule;
use Carbon\Carbon;
use Illuminate\Support\Collection;

final readonly class CoordinatorHelpers
{
    public function buildRoomIds(bool $requireRoom, ?string $roomCode): array
    {
        if (!$requireRoom && (null === $roomCode || '' === $roomCode || '0' === $roomCode || '0' === $roomCode)) {
            return [];
        }
        $q = Room::query()->where('is_active', true);

        if ($roomCode && '0' !== $roomCode) {
            $q->where('code', $roomCode);
        }

        return $q->pluck('id')->all();
    }

    public function clinicSchedules(): Collection
    {
        return \App\Models\ClinicSchedule::query()->get()->groupBy('day_of_week');
    }

    public function isCapReached(?object $insurer): bool
    {
        return $insurer && !is_null($insurer->max_total_appointments) && Appointment::query()->count() >= (int) $insurer->max_total_appointments;
    }

    public function buildClosures(?object $insurer, array $roomIds, Availability $availability, Collection $roomBlocksByRoom, Collection $appointmentsByRoom): array
    {
        $isRoomAvailable = (fn (int $rid, Carbon $s, Carbon $e): bool => $availability->isRoomAvailable($roomBlocksByRoom, $appointmentsByRoom, $rid, $s, $e));
        $pickRoom        = function (Carbon $s, Carbon $e) use ($roomIds, $isRoomAvailable): ?int {
            foreach ($roomIds as $rid) {
                if ($isRoomAvailable((int) $rid, $s, $e)) {
                    return (int) $rid;
                }
            }

            return null;
        };
        $insurerAllows = function (Carbon $d) use ($insurer): bool {
            if ($insurer && !is_null($insurer->allowed_weekdays)) {
                $allowed = is_array($insurer->allowed_weekdays) ? $insurer->allowed_weekdays : json_decode((string) $insurer->allowed_weekdays, true) ?? [];

                return in_array((int) $d->dayOfWeek, array_map('intval', $allowed), true);
            }

            return true;
        };
        $getSchedulesByDoctor = (fn (int $doctorId) => UserSchedule::query()->where('user_id', $doctorId)->get()->groupBy('day_of_week'));

        return ['pickRoom' => $pickRoom, 'insurerAllows' => $insurerAllows, 'getSchedulesByDoctor' => $getSchedulesByDoctor];
    }
}
