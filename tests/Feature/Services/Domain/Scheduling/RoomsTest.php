<?php

declare(strict_types = 1);

use App\Models\ClinicSchedule;
use App\Models\Patient;
use App\Models\Room;
use App\Models\RoomUnavailability;
use App\Models\User;
use App\Models\UserSchedule;
use App\Services\Domain\SchedulingService;
use Carbon\Carbon;

afterEach(function (): void {
    Carbon::setTestNow();
});

it('allocates an available room when requireRoom = true', function (): void {
    $patient = Patient::query()->create(['code' => 'R1', 'name' => 'Pat']);
    $doc     = User::factory()->create(['is_doctor' => true]);
    UserSchedule::create(['user_id' => $doc->id, 'day_of_week' => 1, 'start_time' => '09:00:00', 'end_time' => '12:00:00', 'slot_minutes' => 30]);

    $roomA = Room::factory()->code('A')->create();
    $roomB = Room::factory()->code('B')->create();

    Carbon::setTestNow('2025-09-01 08:00:00');

    $service = new SchedulingService();
    $slots   = $service
        ->setPatientCode($patient->code)
        ->setDoctorId($doc->id)
        ->setProcedureCode(null)
        ->setMinDate(Carbon::now())
        ->setRequireRoom(true)
        ->find();

    expect($slots->isEmpty())->toBeFalse();
    $first = $slots->first();
    expect($first['start_at']->toDateTimeString())->toBe('2025-09-01 09:00:00')
        ->and($first)->toHaveKey('room_id')
        ->and($first['room_id'])->not()->toBeNull()
        ->and([$roomA->id, $roomB->id])->toContain($first['room_id']);
});

it('respects room unavailability and finds next slot with room', function (): void {
    $patient = Patient::query()->create(['code' => 'R2', 'name' => 'Pat2']);
    $doc     = User::factory()->create(['is_doctor' => true]);
    UserSchedule::create(['user_id' => $doc->id, 'day_of_week' => 1, 'start_time' => '09:00:00', 'end_time' => '11:00:00', 'slot_minutes' => 30]);

    $room = Room::factory()->code('C')->create();
    // Block first slot 09:00-09:30 for the room
    RoomUnavailability::query()->create(['room_id' => $room->id, 'start_at' => '2025-09-01 09:00:00', 'end_at' => '2025-09-01 09:30:00']);

    Carbon::setTestNow('2025-09-01 08:00:00');

    $service = new SchedulingService();
    $slots   = $service
        ->setPatientCode($patient->code)
        ->setDoctorId($doc->id)
        ->setProcedureCode(null)
        ->setMinDate(Carbon::now())
        ->setRoomCode('C')
        ->setRequireRoom(true)
        ->find();

    expect($slots->isEmpty())->toBeFalse();
    $first = $slots->first();
    expect($first['start_at']->toDateTimeString())->toBe('2025-09-01 09:30:00')
        ->and($first['room_id'])->toBe($room->id);
});

it('supports clinic-general scheduling with required room using clinic schedules', function (): void {
    $patient = Patient::query()->create(['code' => 'R3', 'name' => 'Pat3']);
    // Clinic schedule Thursday 10:00-11:00
    ClinicSchedule::query()->create(['day_of_week' => 4, 'start_time' => '10:00:00', 'end_time' => '11:00:00', 'slot_minutes' => 30]);

    $room = Room::factory()->code('D')->create();

    Carbon::setTestNow('2025-09-04 08:00:00'); // Thursday

    $service = new SchedulingService();
    $slots   = $service
        ->setPatientCode($patient->code)
        ->setDoctorId(null)
        ->setProcedureCode(null)
        ->setMinDate(Carbon::now())
        ->setRoomCode('D')
        ->setRequireRoom(true)
        ->find();

    expect($slots->isEmpty())->toBeFalse();
    $first = $slots->first();
    expect($first['doctor_id'])->toBeNull()
        ->and($first['room_id'])->toBe($room->id)
        ->and($first['start_at']->toDateTimeString())->toBe('2025-09-04 10:00:00');
});
