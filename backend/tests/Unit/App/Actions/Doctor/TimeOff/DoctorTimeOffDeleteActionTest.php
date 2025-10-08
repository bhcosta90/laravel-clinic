<?php

declare(strict_types=1);

use App\Actions\Doctor\TimeOff\DoctorTimeOffDeleteAction;
use App\Models\Doctor;
use App\Models\DoctorTimeOff;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertSoftDeleted;

test('delete time off action', function () {
    $doctor = Doctor::factory()->create();
    $time = DoctorTimeOff::factory()->for($doctor)->create();

    $response = app(DoctorTimeOffDeleteAction::class)->execute($doctor->id, $time->id);

    expect($response)->toBeTrue();

    assertSoftDeleted(DoctorTimeOff::class, ['id' => $time->id]);
});

test('delete time off action with mismatched doctor', function () {
    $doctor = Doctor::factory()->create();
    $time = DoctorTimeOff::factory()->create();

    $response = app(DoctorTimeOffDeleteAction::class)->execute($doctor->id, $time->id);

    expect($response)->toBeFalse();

    assertDatabaseHas(DoctorTimeOff::class, ['id' => $time->id, 'deleted_at' => null]);
});
