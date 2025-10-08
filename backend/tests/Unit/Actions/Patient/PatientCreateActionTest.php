<?php

declare(strict_types=1);

use App\Actions\Patient\PatientCreateAction;
use App\Models\Patient;

use function Pest\Laravel\assertDatabaseHas;

test('create patient action', function () {
    $name = 'Test Patient';

    $patient = app(PatientCreateAction::class)->execute($name);

    expect($patient)->toBeInstanceOf(Patient::class)
        ->and($patient->name)->toBe($name);

    assertDatabaseHas(Patient::class, compact('name'));
});
