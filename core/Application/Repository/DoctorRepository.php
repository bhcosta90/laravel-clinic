<?php

namespace Core\Application\Repository;

use App\Models\User as Doctor;
use App\Models\UserSchedule;
use Core\Application\Repository\Traits\Doctor\DoctorScheduleTrait;
use Core\Domain\Entities\Aggregate\ScheduleAggregate;
use Core\Domain\Entities\DoctorEntity;
use Core\Domain\Entities\Requests\Doctor\DoctorCreateRequest;
use Core\Domain\Repository\DoctorRepositoryInterface;
use Core\Shared\Domain\BaseDomain;
use Illuminate\Database\Eloquent\Model;

class DoctorRepository implements DoctorRepositoryInterface
{
    use DoctorScheduleTrait;

    public function find(
        int|string $id,
        ?ScheduleAggregate $aggregate = null
    ): ?BaseDomain {
        $domain = $this->convertModelToDomain($this->getModelById($id));

        if ($aggregate) {
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
