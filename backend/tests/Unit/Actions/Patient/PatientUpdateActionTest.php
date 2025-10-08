<?php

declare(strict_types=1);

use App\Actions\Patient\PatientUpdateAction;
use App\Models\Patient;

use function Pest\Laravel\assertDatabaseHas;

test('update patient action', function () {
    $patient = Patient::factory()->create();

    $newName = 'Updated Patient';

    $response = app(PatientUpdateAction::class)->execute($patient, $newName);

    expect($response)->toBeInstanceOf(Patient::class)
        ->and($patient->name)->toBe($newName);

    assertDatabaseHas(Patient::class, ['name' => $newName]);
});
