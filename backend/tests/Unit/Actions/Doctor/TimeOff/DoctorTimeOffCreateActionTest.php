<?php

declare(strict_types=1);

use App\Actions\Doctor\TimeOff\DoctorTimeOffCreateAction;
use App\Models\Doctor;
use App\Models\DoctorTimeOff;
use Illuminate\Validation\ValidationException;

use function Pest\Laravel\assertDatabaseCount;

test('should not allow overlapping time off', function () {
    $doctor = Doctor::factory()->create();
    $doctor->timeOff()->create([
        'start_at' => '2024-06-01 09:00:00',
        'end_at' => '2024-06-01 11:00:00',
    ]);

    $service = app(DoctorTimeOffCreateAction::class);
    expect(fn () => $service->execute($doctor, new DateTimeImmutable('2024-06-01 10:00'), new DateTimeImmutable('2024-06-01 12:00')))
        ->toThrow(ValidationException::class);
});

test('should create time off when no overlap', function () {
    $doctor = Doctor::factory()->create();
    $doctor->timeOff()->create([
        'start_at' => '2024-06-01 13:00:00',
        'end_at' => '2024-06-01 14:00:00',
    ]);

    $service = app(DoctorTimeOffCreateAction::class);
    $result = $service->execute($doctor, new DateTimeImmutable('2024-06-01 10:00'), new DateTimeImmutable('2024-06-01 12:00'));

    expect($result)->toBeInstanceOf(DoctorTimeOff::class);

    assertDatabaseCount(DoctorTimeOff::class, 2);
});
