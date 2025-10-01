<?php

declare(strict_types = 1);

use Core\Domain\Entities\Aggregate\ScheduleAggregate;
use Core\Domain\Entities\DoctorEntity;
use Core\Domain\Entities\Requests\Doctor\DoctorCreateRequest;
use Core\Domain\Entities\Requests\Doctor\DoctorUpdateRequest;
use Core\Domain\Enum\DayEnum;
use Core\Shared\Domain\Exception\ValidationException;

beforeEach(function () {
    $this->entity = new DoctorEntity(new DoctorCreateRequest(name: 'testing'));
});

test('should update doctor name', function () {
    $this->entity->update(new DoctorUpdateRequest(name: 'testing 123'));
    expect($this->entity->name)->toBe('testing 123');
});

test('should add a schedule', function () {
    expect($this->entity->schedules)->toHaveCount(0);

    $this->entity->addSchedule(new ScheduleAggregate(
        dayOfWeek: DayEnum::Monday,
        startTime: '00:00',
        endTime: '01:00',
        slotMinutes: 60,
    ));

    expect($this->entity->schedules)->toHaveCount(1);
});

test('should add schedules for different days', function () {
    expect($this->entity->schedules)->toHaveCount(0);

    $this->entity->addSchedule(new ScheduleAggregate(
        dayOfWeek: DayEnum::Monday,
        startTime: '00:00',
        endTime: '01:00',
        slotMinutes: 60,
    ));
    $this->entity->addSchedule(new ScheduleAggregate(
        dayOfWeek: DayEnum::Thursday,
        startTime: '00:00',
        endTime: '01:00',
        slotMinutes: 60,
    ));

    expect($this->entity->schedules)->toHaveCount(2);
});

test('should throw when start time is after end time', function () {
    expect(fn () => $this->entity->addSchedule(new ScheduleAggregate(
        dayOfWeek: DayEnum::Monday,
        startTime: '02:00',
        endTime: '01:00',
        slotMinutes: 60,
    )))->toThrow(ValidationException::class);
});

test('should throw for invalid time formats', function () {
    expect(fn () => $this->entity->addSchedule(new ScheduleAggregate(
        dayOfWeek: DayEnum::Monday,
        startTime: '00:00',
        endTime: '30:00',
        slotMinutes: 60,
    )))->toThrow(ValidationException::class)
        ->and(fn () => $this->entity->addSchedule(new ScheduleAggregate(
            dayOfWeek: DayEnum::Monday,
            startTime: '30:00',
            endTime: '00:00',
            slotMinutes: 60,
        )))->toThrow(ValidationException::class)
        ->and(fn () => $this->entity->addSchedule(new ScheduleAggregate(
            dayOfWeek: DayEnum::Monday,
            startTime: '30',
            endTime: '00:00',
            slotMinutes: 60,
        )))->toThrow(ValidationException::class);
});

test('should not allow overlapping schedules', function () {
    $this->entity->addSchedule(new ScheduleAggregate(
        dayOfWeek: DayEnum::Monday,
        startTime: '03:00',
        endTime: '03:59',
        slotMinutes: 60,
    ));

    expect(fn () => $this->entity->addSchedule(new ScheduleAggregate(
        dayOfWeek: DayEnum::Monday,
        startTime: '03:00',
        endTime: '03:59',
        slotMinutes: 60,
    )))->toThrow(ValidationException::class);
});
