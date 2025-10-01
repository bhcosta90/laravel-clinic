<?php

namespace Core\Domain\Entities;

use Core\Domain\Entities\Aggregate\ScheduleAggregate;
use Core\Domain\Entities\Requests\Doctor\DoctorCreateRequest;
use Core\Domain\Entities\Requests\Doctor\DoctorUpdateRequest;
use Core\Shared\Domain\BaseDomain;
use Core\Shared\Domain\Exception\ValidationException;

class DoctorEntity extends BaseDomain
{
    protected string $name;

    protected array $schedules = [];

    public function __construct(DoctorCreateRequest $request, string|int|null $id = null)
    {
        $this->name = $request->name;
        $this->validate();
        parent::__construct($id);
    }

    public function validate(): void
    {
        $this->validator()
            ->data([
                'nome' => $this->name,
            ])
            ->field('nome')->required()->min(3)
            ->validate();
    }

    public function update(DoctorUpdateRequest $request): void
    {
        $this->name = $request->name;
        $this->validate();
    }

    public function addSchedule(ScheduleAggregate $aggregate): void
    {
        $dayOfWeek = $aggregate->dayOfWeek;
        $startTime = $aggregate->startTime;
        $endTime = $aggregate->endTime;
        $slotMinutes = $aggregate->slotMinutes;

        // Validate day of week
        $this->validator()
            ->data([
                'day_of_week' => $dayOfWeek,
                'slot_minutes' => $slotMinutes,
            ])
            ->field('slot_minutes')->required()->min(1)
            ->validate();

        $errors = [];
        $startSeconds = $this->parseTimeToSeconds($startTime);
        $endSeconds = $this->parseTimeToSeconds($endTime);

        if ($startSeconds === null) {
            $errors['start_time'][] = 'Invalid time format. Expected HH:MM:SS';
        }
        if ($endSeconds === null) {
            $errors['end_time'][] = 'Invalid time format. Expected HH:MM:SS';
        }
        if (empty($errors) && $startSeconds >= $endSeconds) {
            $errors['time'][] = 'start_time must be earlier than end_time';
        }

        // Check overlap with existing schedules for the same day
        if (empty($errors)) {
            foreach ($this->schedules as $schedule) {
                if ($schedule['day_of_week'] !== $dayOfWeek) {
                    continue;
                }

                $existingStart = $this->parseTimeToSeconds($schedule['start_time']);
                $existingEnd = $this->parseTimeToSeconds($schedule['end_time']);

                if ($startSeconds < $existingEnd && $endSeconds > $existingStart && $aggregate->id !== $schedule['id']) {
                    $errors['schedule'][] = 'Schedule time range conflicts with an existing schedule for this day.';
                    break;
                }
            }
        }

        if ($errors) {
            throw new ValidationException($errors);
        }

        $this->schedules[] = [
            'id' => $aggregate->id,
            'day_of_week' => $dayOfWeek,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'slot_minutes' => $slotMinutes,
        ];
    }

    private function parseTimeToSeconds(string $time): ?int
    {
        // Expecting format HH:MM or HH:MM:SS
        $parts = explode(':', $time);
        if (count($parts) < 2 || count($parts) > 3) {
            return null;
        }
        $h = (int) ($parts[0] ?? 0);
        $m = (int) ($parts[1] ?? 0);
        $s = (int) ($parts[2] ?? 0);
        if ($h < 0 || $h > 23 || $m < 0 || $m > 59 || $s < 0 || $s > 59) {
            return null;
        }

        return $h * 3600 + $m * 60 + $s;
    }
}
