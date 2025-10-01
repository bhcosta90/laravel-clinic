<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\V1\Doctor;

use App\Http\Controllers\Api\V1\Traits\ReadTrait;
use App\Http\Requests\DoctorScheduleRequest;
use App\Models\UserSchedule;
use Core\Application\Handler\Doctor\Schedule as Handler;
use Core\Domain\Enum\DayEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

final class ScheduleController
{
    use ReadTrait;

    private array $allowedIncludes = [
        'id',
        'day_of_week',
        'start_time',
        'end_time',
        'slot_minutes',
    ];

    public function store(DoctorScheduleRequest $procedureRequest, Handler\DoctorScheduleCreateHandler $handler, int $doctorId)
    {
        return response()->json([
            'data' => $handler->execute(new Handler\Data\DoctorScheduleCreateInput(
                $doctorId,
                $this->convertDayWeek($procedureRequest->day_of_week),
                $procedureRequest->start_time,
                $procedureRequest->end_time,
                $procedureRequest->slot_minutes,
            )),
        ]);
    }

    public function update(DoctorScheduleRequest $procedureRequest, Handler\DoctorScheduleUpdateHandler $handler, int $doctorId, int $scheduleId)
    {
        return response()->json([
            'data' => $handler->execute(new Handler\Data\DoctorScheduleUpdateInput(
                $scheduleId,
                $doctorId,
                when($procedureRequest->day_of_week, fn () => $this->convertDayWeek($procedureRequest->day_of_week)),
                $procedureRequest->start_time,
                $procedureRequest->end_time,
                $procedureRequest->slot_minutes,
            )),
        ]);
    }

    public function destroy(Handler\DoctorScheduleDeleteHandler $handler, int $doctorId, int $scheduleId)
    {
        return response()->json([
            'data' => $handler->execute(
                $scheduleId,
                $doctorId,
            ),
        ]);
    }

    protected function model(): Model
    {
        return new UserSchedule();
    }

    protected function defaultQuery(Builder $queryBuilder)
    {
        return $queryBuilder->where('user_id', request()->route('doctor_id'));
    }

    private function convertDayWeek(string $dayOfWeek): DayEnum
    {
        return DayEnum::from(DayEnum::{ucfirst($dayOfWeek)}->value);
    }
}
