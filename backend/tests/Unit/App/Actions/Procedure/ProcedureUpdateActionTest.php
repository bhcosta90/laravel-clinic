<?php

declare(strict_types=1);

use App\Actions\Procedure\ProcedureUpdateAction;
use App\Models\Procedure;

use function Pest\Laravel\assertDatabaseHas;

test('update procedure action', function () {
    $procedure = Procedure::factory()->create();

    $newName = 'Updated Procedure';

    $response = app(ProcedureUpdateAction::class)->execute($procedure, $newName);

    expect($response)->toBeInstanceOf(Procedure::class)
        ->and($procedure->name)->toBe($newName);

    assertDatabaseHas(Procedure::class, ['name' => $newName]);
});
