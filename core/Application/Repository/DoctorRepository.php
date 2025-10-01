<?php

namespace Core\Application\Repository;

use App\Models\User as Doctor;
use App\Models\UserSchedule;
use Core\Domain\Entities\Aggregate\ScheduleAggregate;
use Core\Domain\Entities\DoctorEntity;
use Core\Domain\Entities\Requests\Doctor\DoctorCreateRequest;
use Core\Domain\Repository\DoctorRepositoryInterface;
use Core\Shared\Domain\BaseDomain;
use Illuminate\Database\Eloquent\Model;

class DoctorRepository implements DoctorRepositoryInterface
{
    public function find(
        int|string $id,
        ?ScheduleAggregate $aggregate = null
    ): ?BaseDomain {
        $domain = $this->convertModelToDomain($this->getModelById($id));

        if ($aggregate->dayOfWeek || $aggregate->startTime || $aggregate->endTime || $aggregate->id) {
            $this->getSchedule($domain, $aggregate);
        }

        return $domain;
    }

    public function delete(BaseDomain $domain): bool
    {
        return $this->getModelById($domain->id)->delete();
    }

    public function store(BaseDomain $domain): BaseDomain
    {
        $model = new Doctor;
        $model->fill([
            'name' => $domain->name,
            'is_doctor' => true,
        ]);
        $model->save();

        return $this->convertModelToDomain($model);
    }

    public function update(BaseDomain $domain): BaseDomain
    {
        $model = $this->getModelById($domain->id);
        $model->fill([
            'name' => $domain->name,
        ]);
        $model->save();

        return $this->convertModelToDomain($model);
    }

    public function storeSchedule(DoctorEntity $entity): ScheduleAggregate
    {
        $user = $this->getModelById($entity->id);

        $schedules = $entity->schedules;
        $schedule = array_pop($schedules);

        $schedule = $user->schedules()->create([
            'day_of_week' => $schedule['day_of_week'],
            'start_time' => $schedule['start_time'],
            'end_time' => $schedule['end_time'],
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
                'day_of_week' => $aggregate->dayOfWeek,
                'start_time' => $aggregate->startTime,
                'end_time' => $aggregate->endTime,
                'slot_minutes' => $aggregate->slotMinutes,
            ]);

            return $this->convertScheduleAggregate($schedule);
        }

        return null;
    }

    public function deleteSchedule(DoctorEntity $entity, ScheduleAggregate $aggregate): bool
    {
        return UserSchedule::query()
            ->where('id', $aggregate->id)
            ->where('user_id', $entity->id)
            ->delete();
    }

    public function findSchedule(DoctorEntity $doctor, int|string $id): ?ScheduleAggregate
    {
        $schedule = array_filter($doctor->schedules, fn ($item) => $item['id'] === $id)[0] ?? null;

        return when($schedule, fn () => $this->convertScheduleAggregate((object) [
            'id' => $id,
            'day_of_week' => $schedule['day_of_week'],
            'start_time' => $schedule['start_time'],
            'end_time' => $schedule['end_time'],
            'slot_minutes' => $schedule['slot_minutes'],
        ]));
    }

    protected function model(): Model
    {
        return new Doctor;
    }

    protected function getModelById(int|string $id): ?Model
    {
        return $this->model()->query()->find($id);
    }

    protected function convertModelToDomain(?object $model): ?DoctorEntity
    {
        return when($model, fn () => new DoctorEntity(new DoctorCreateRequest(
            name: $model->name,
        ), (int) $model->id));
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

    protected function getSchedule(DoctorEntity $entity, ScheduleAggregate $aggregate): void
    {
        $dayOfWeek = $aggregate->dayOfWeek;
        $startTime = when($aggregate->startTime, fn () => now()->setTimeFromTimeString($aggregate->startTime)->format('H:i'));
        $endTime = when($aggregate->endTime, fn () => now()->setTimeFromTimeString($aggregate->endTime)->format('H:i'));

        UserSchedule::when($dayOfWeek, fn ($query) => $query->where('day_of_week', $dayOfWeek))
            ->when($startTime && $endTime, fn ($query) => $query->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<', $startTime)
                            ->where('end_time', '>', $endTime);
                    });
            }))
            ->where('user_id', $entity->id)
            ->when($aggregate->id, fn ($query) => $query->where('id', $aggregate->id))
            ->each(fn ($item) => $entity->addSchedule(new ScheduleAggregate(
                dayOfWeek: $item->day_of_week,
                startTime: $item->start_time,
                endTime: $item->end_time,
                slotMinutes: $item->slot_minutes,
                id: $item->id,
            )));
    }
}
