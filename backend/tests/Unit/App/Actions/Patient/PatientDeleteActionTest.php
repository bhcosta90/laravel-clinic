<?php

declare(strict_types=1);

use App\Actions\Patient\PatientDeleteAction;
use App\Models\Patient;

use function Pest\Laravel\assertSoftDeleted;

test('delete patient action', function () {
    $patient = Patient::factory()->create();

    $response = app(PatientDeleteAction::class)->execute($patient);

    expect($response)->toBeTrue();

    assertSoftDeleted(Patient::class, ['id' => $patient->id]);
});
