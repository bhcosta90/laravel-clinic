<?php

use App\Models\User;
use App\Models\UserSchedule;
use Core\Domain\Entities\Aggregate\ScheduleAggregate;
use Core\Domain\Entities\DoctorEntity;
use Core\Domain\Enum\DayEnum;
use Core\Domain\Repository\DoctorRepositoryInterface;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    $this->doctor = User::factory()
        ->has(
            UserSchedule::factory()
                ->count(5)
                ->sequence(
                    ['start_time' => '00:00', 'end_time' => '01:00', 'day_of_week' => 0],
                    ['start_time' => '01:00', 'end_time' => '02:00', 'day_of_week' => 0],
                    ['start_time' => '02:00', 'end_time' => '03:00', 'day_of_week' => 0],
                    ['start_time' => '03:00', 'end_time' => '04:00', 'day_of_week' => 0],
                    ['start_time' => '04:00', 'end_time' => '05:00', 'day_of_week' => 0],
                ),
            'schedules'
        )
        ->create();

    $this->handler = app(DoctorRepositoryInterface::class);
});

test('100', function () {
    $response = $this->handler->find($this->doctor->id);

    expect($response)->toBeInstanceOf(DoctorEntity::class)
        ->and($response->schedules)->toHaveCount(0)
        ->and($response)->name->toBe($this->doctor->name)
        ->id->toBe($this->doctor->id)
        ->createdAt->format('YmdHis')->toBe($this->doctor->created_at->format('YmdHis'))
        ->updatedAt->format('YmdHis')->toBe($this->doctor->updated_at->format('YmdHis'));
});

test('200', function () {
    $response = $this->handler->find($this->doctor->id, new ScheduleAggregate);

    expect($response)->toBeInstanceOf(DoctorEntity::class)
        ->and($response->schedules)->toHaveCount(5);
});

test('300', function () {
    /** @var DoctorEntity $response */
    $response = $this->handler->find($this->doctor->id, new ScheduleAggregate);

    $response->addSchedule(new ScheduleAggregate(
        dayOfWeek: DayEnum::Thursday,
        startTime: '00:00',
        endTime: '01:00',
        slotMinutes: 60,
    ));

    $schedule = $this->handler->storeSchedule($response);

    $response = $this->handler->find($this->doctor->id, new ScheduleAggregate);
    expect($response->schedules)->toHaveCount(6);

    assertDatabaseHas(UserSchedule::class, [
        'id' => $schedule->id,
        'day_of_week' => DayEnum::Thursday,
        'start_time' => '00:00',
        'end_time' => '01:00',
        'slot_minutes' => 60,
        'user_id' => $this->doctor->id,
        'deleted_at' => null,
    ]);
});

test('401', function () {
    /** @var DoctorEntity $response */
    $doctor = $this->handler->find($this->doctor->id, new ScheduleAggregate);
    $scheduleId = $doctor->schedules[0]['id'];

    $response = $this->handler->findSchedule($doctor, $scheduleId);

    expect($response)->dayOfWeek->toBe(DayEnum::Monday)
        ->startTime->toBe('00:00')
        ->endTime->toBe('01:00')
        ->id->toBe($scheduleId);

    $response = $this->handler->findSchedule($doctor, 0);
    expect($response)->toBeNull();
});

test('400', function () {
    /** @var DoctorEntity $response */
    $schedule = $this->handler->find($this->doctor->id, new ScheduleAggregate);
    $scheduleId = $schedule->schedules[0]['id'];

    $response = $this->handler->updateSchedule($schedule, new ScheduleAggregate(
        dayOfWeek: DayEnum::Thursday,
        startTime: '00:00',
        endTime: '01:00',
        slotMinutes: 60,
        id: $scheduleId
    ));

    expect($response)->dayOfWeek->toBe(DayEnum::Thursday)
        ->startTime->toBe('00:00')
        ->endTime->toBe('01:00')
        ->slotMinutes->toBe(60)
        ->id->toBe($scheduleId);

    assertDatabaseHas(UserSchedule::class, [
        'id' => $scheduleId,
        'day_of_week' => DayEnum::Thursday,
        'start_time' => '00:00',
        'end_time' => '01:00',
        'slot_minutes' => 60,
        'user_id' => $this->doctor->id,
        'deleted_at' => null,
    ]);

    $response = $this->handler->updateSchedule($schedule, new ScheduleAggregate(
        dayOfWeek: DayEnum::Thursday,
        startTime: '00:00',
        endTime: '01:00',
        slotMinutes: 60,
        id: 0
    ));
    expect($response)->toBeNull();
});

test('500', function () {
    /** @var DoctorEntity $response */
    $response = $this->handler->find($this->doctor->id, new ScheduleAggregate);
    $scheduleId = $response->schedules[0]['id'];

    expect($this->handler->deleteSchedule($response, new ScheduleAggregate(id: $scheduleId)))->toBeTrue()
        ->and($this->handler->deleteSchedule($response, new ScheduleAggregate(id: 0)))->toBeFalse();
});

test('600', function () {
    /** @var DoctorEntity $response */
    $response = $this->handler->find($this->doctor->id, new ScheduleAggregate(
        dayOfWeek: DayEnum::Monday,
        startTime: '00:00',
        endTime: '00:30',
        slotMinutes: 60,
    ));
    expect($response->schedules)->toHaveCount(1);
});

test('601', function () {
    /** @var DoctorEntity $response */
    $response = $this->handler->find($this->doctor->id, new ScheduleAggregate(
        dayOfWeek: DayEnum::Monday,
        startTime: '00:30',
        endTime: '01:01',
        slotMinutes: 60,
    ));
    expect($response->schedules)->toHaveCount(2);
});

test('602', function () {
    /** @var DoctorEntity $response */
    $response = $this->handler->find($this->doctor->id, new ScheduleAggregate(
        dayOfWeek: DayEnum::Monday,
        startTime: '04:00',
        endTime: '04:30',
        slotMinutes: 60,
    ));
    expect($response->schedules)->toHaveCount(2);
});
