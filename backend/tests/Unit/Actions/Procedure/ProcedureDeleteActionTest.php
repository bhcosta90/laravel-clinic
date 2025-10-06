<?php

declare(strict_types=1);

use App\Actions\Procedure\ProcedureDeleteAction;
use App\Models\Procedure;

use function Pest\Laravel\assertSoftDeleted;

test('delete procedure action', function () {
    $procedure = Procedure::factory()->create();

    $response = app(ProcedureDeleteAction::class)->execute($procedure);

    expect($response)->toBeTrue();

    assertSoftDeleted(Procedure::class, ['id' => $procedure->id]);
});
