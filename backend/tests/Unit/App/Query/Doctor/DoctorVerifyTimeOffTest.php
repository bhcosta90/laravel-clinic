<?php

declare(strict_types=1);

use App\Models\Doctor;
use App\Query\Doctor\DoctorVerifyTimeOff;

test('returns true when there is a time off conflict due to overlapping interval', function () {
    $doctor = Doctor::factory()->create();
    $doctor->timeOff()->create([
        'start_at' => '2024-06-01 09:00:00',
        'end_at' => '2024-06-01 11:00:00',
    ]);

    $service = app(DoctorVerifyTimeOff::class);
    $result = $service->execute($doctor, new DateTimeImmutable('2024-06-01 10:00'), new DateTimeImmutable('2024-06-01 12:00'));

    expect($result)->toBeTrue();
});

test('returns false when there is no time off conflict', function () {
    $doctor = Doctor::factory()->create();
    $doctor->timeOff()->create([
        'start_at' => '2024-06-01 13:00:00',
        'end_at' => '2024-06-01 14:00:00',
    ]);

    $service = app(DoctorVerifyTimeOff::class);
    $result = $service->execute($doctor, new DateTimeImmutable('2024-06-01 10:00'), new DateTimeImmutable('2024-06-01 12:00'));

    expect($result)->toBeFalse();
});

test('ignores time off with the same id as provided', function () {
    $doctor = Doctor::factory()->create();
    $timeOff = $doctor->timeOff()->create([
        'start_at' => '2024-06-01 09:00:00',
        'end_at' => '2024-06-01 11:00:00',
    ]);

    $service = app(DoctorVerifyTimeOff::class);
    $result = $service->execute($doctor, new DateTimeImmutable('2024-06-01 10:00'), new DateTimeImmutable('2024-06-01 12:00'), $timeOff->id);

    expect($result)->toBeFalse();
});
