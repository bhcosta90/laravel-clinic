<?php

declare(strict_types=1);

use App\Actions\Specialty\SpecialtyUpdateAction;
use App\Models\Specialty;

use function Pest\Laravel\assertDatabaseHas;

test('update specialty action', function () {
    $specialty = Specialty::factory()->create();

    $newName = 'Updated Specialty';

    $response = app(SpecialtyUpdateAction::class)->execute($specialty, $newName);

    expect($response)->toBeInstanceOf(Specialty::class)
        ->and($specialty->name)->toBe($newName);

    assertDatabaseHas(Specialty::class, ['name' => $newName]);
});
