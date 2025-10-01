<?php

namespace App\Http\Controllers\Api\V1\Doctor;

use App\Http\Requests\DoctorScheduleRequest;
use Core\Application\Handler\Doctor\Schedule as Handler;
use Core\Domain\Enum\DayEnum;

class ScheduleController
{
    public function store(DoctorScheduleRequest $procedureRequest, Handler\DoctorScheduleCreateHandler $handler, int $doctorId)
    {
        return response()->json([
            'data' => $handler->execute(
                $doctorId,
                $this->convertDayWeek($procedureRequest->day_of_week),
                $procedureRequest->start_time,
                $procedureRequest->end_time,
                $procedureRequest->slot_minutes,
            ),
        ]);
    }

    public function update(DoctorScheduleRequest $procedureRequest, Handler\DoctorScheduleUpdateHandler $handler, int $doctorId, int $scheduleId)
    {
        return response()->json([
            'data' => $handler->execute(
                $scheduleId,
                $doctorId,
                when($procedureRequest->day_of_week, fn () => $this->convertDayWeek($procedureRequest->day_of_week)),
                $procedureRequest->start_time,
                $procedureRequest->end_time,
                $procedureRequest->slot_minutes,
            ),
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

    protected function convertDayWeek(string $dayOfWeek): DayEnum
    {
        return DayEnum::from(DayEnum::{ucfirst($dayOfWeek)}->value);
    }
}
