<?php

declare(strict_types=1);

use App\Actions\Procedure\ProcedureCreateAction;
use App\Models\Procedure;

use function Pest\Laravel\assertDatabaseHas;

test('create procedure action', function () {
    $name = 'Test Procedure';

    $procedure = app(ProcedureCreateAction::class)->execute($name);

    expect($procedure)->toBeInstanceOf(Procedure::class)
        ->and($procedure->name)->toBe($name);

    assertDatabaseHas(Procedure::class, compact('name'));
});
