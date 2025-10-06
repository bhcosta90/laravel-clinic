<?php

declare(strict_types=1);

use App\Actions\Doctor\DoctorCreateAction;
use App\Models\Doctor;
use App\Models\User;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;

test('create doctor action', function () {
    $name = 'Test Doctor';
    $crm = 'crm';

    $doctor = app(DoctorCreateAction::class)->execute($name, $crm, 'password');

    expect($doctor)->toBeInstanceOf(Doctor::class)
        ->and($doctor->name)->toBe($name)
        ->and($doctor->crm)->toBe($crm);

    assertDatabaseHas(Doctor::class, compact('name', 'crm'));
    assertDatabaseCount(User::class, 1);
});
