<?php

declare(strict_types=1);

use App\Actions\Specialty\SpecialtyCreateAction;
use App\Models\Specialty;

use function Pest\Laravel\assertDatabaseHas;

test('create specialty action', function () {
    $name = 'Test Specialty';

    $specialty = app(SpecialtyCreateAction::class)->execute($name);

    expect($specialty)->toBeInstanceOf(Specialty::class)
        ->and($specialty->name)->toBe($name);

    assertDatabaseHas(Specialty::class, compact('name'));
});
