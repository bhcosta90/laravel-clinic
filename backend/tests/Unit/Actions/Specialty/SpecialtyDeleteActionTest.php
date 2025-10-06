<?php

declare(strict_types=1);

use App\Actions\Specialty\SpecialtyDeleteAction;
use App\Models\Specialty;

use function Pest\Laravel\assertSoftDeleted;

test('delete specialty action', function () {
    $specialty = Specialty::factory()->create();

    $response = app(SpecialtyDeleteAction::class)->execute($specialty);

    expect($response)->toBeTrue();

    assertSoftDeleted(Specialty::class, ['id' => $specialty->id]);
});
