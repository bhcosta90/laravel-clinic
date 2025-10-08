<?php

declare(strict_types=1);

use App\Actions\Doctor\DoctorUpdateAction;
use App\Models\Doctor;

use function Pest\Laravel\assertDatabaseHas;

test('update doctor action', function () {
    $doctor = Doctor::factory()->create();

    $newName = 'Updated Shared';
    $newCrm = 'new-crm';

    $response = app(DoctorUpdateAction::class)->execute($doctor, $newName, $newCrm);

    expect($response)->toBeInstanceOf(Doctor::class)
        ->and($doctor->name)->toBe($newName)
        ->and($doctor->crm)->toBe($newCrm);

    assertDatabaseHas(Doctor::class, ['name' => $newName, 'crm' => $newCrm]);

});
