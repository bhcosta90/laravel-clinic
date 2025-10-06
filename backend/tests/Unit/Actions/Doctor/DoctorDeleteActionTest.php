<?php

declare(strict_types=1);

use App\Actions\Doctor\DoctorDeleteAction;
use App\Models\Doctor;
use App\Models\User;

use function Pest\Laravel\assertSoftDeleted;

test('delete doctor action', function () {
    $doctor = Doctor::factory()->create();

    $response = app(DoctorDeleteAction::class)->execute($doctor);

    expect($response)->toBeTrue();

    assertSoftDeleted(Doctor::class, ['user_id' => $doctor->user_id]);
    assertSoftDeleted(User::class, ['id' => $doctor->user_id]);
});
