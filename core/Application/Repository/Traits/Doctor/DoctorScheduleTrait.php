<?php

declare(strict_types = 1);

namespace Core\Application\Repository\Traits\Doctor;

use App\Models\UserSchedule;
use Core\Domain\Entities\Aggregate\ScheduleAggregate;
use Core\Domain\Entities\DoctorEntity;
use Illuminate\Database\Eloquent\Model;

trait DoctorScheduleTrait
{
    abstract protected function getModelById(int | string $id): ?Model;

    public function storeSchedule(DoctorEntity $entity): ScheduleAggregate
    {
        $user = $this->getModelById($entity->id);

        $schedules = $entity->schedules;
        $schedule  = array_pop($schedules);

        $schedule = $user->schedules()->create([
            'day_of_week'  => $schedule['day_of_week'],
            'start_time'   => $schedule['start_time'],
            'end_time'     => $schedule['end_time'],
            'slot_minutes' => $schedule['slot_minutes'],
        ]);

        return new ScheduleAggregate(
            dayOfWeek: $schedule->day_of_week,
            startTime: $schedule->start_time,
            endTime: $schedule->end_time,
            slotMinutes: $schedule->slot_minutes,
            id: $schedule->id,
        );
    }

    public function updateSchedule(DoctorEntity $entity, ScheduleAggregate $aggregate): ?ScheduleAggregate
    {
        $schedule = UserSchedule::query()
            ->where('id', $aggregate->id)
            ->where('user_id', $entity->id)
            ->first();

        if ($schedule) {
            $schedule->update([
                'day_of_week'  => $aggregate->dayOfWeek,
                'start_time'   => $aggregate->startTime,
                'end_time'     => $aggregate->endTime,
                'slot_minutes' => $aggregate->slotMinutes,
            ]);

            return $this->convertScheduleAggregate($schedule);
        }

        return null;
    }

    public function deleteSchedule(DoctorEntity $entity, ScheduleAggregate $aggregate): bool
    {
        return (bool) UserSchedule::query()
            ->where('id', $aggregate->id)
            ->where('user_id', $entity->id)
            ->delete();
    }

    public function findSchedule(DoctorEntity $doctor, int | string $id): ?ScheduleAggregate
    {
        $schedule = array_filter($doctor->schedules, fn ($item) => $item['id'] === $id)[0] ?? null;

        return when($schedule, fn () => $this->convertScheduleAggregate((object) [
            'id'           => $id,
            'day_of_week'  => $schedule['day_of_week'],
            'start_time'   => $schedule['start_time'],
            'end_time'     => $schedule['end_time'],
            'slot_minutes' => $schedule['slot_minutes'],
        ]));
    }

    protected function convertScheduleAggregate(?object $model): ?ScheduleAggregate
    {
        return when($model, fn () => new ScheduleAggregate(
            dayOfWeek: $model->day_of_week,
            startTime: $model->start_time,
            endTime: $model->end_time,
            slotMinutes: $model->slot_minutes,
            id: $model->id,
        ));
    }
}
