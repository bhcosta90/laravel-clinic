<?php

declare(strict_types=1);

use App\Actions\Procedure\ProcedureDeleteAction;
use App\Models\Procedure;
use App\Models\User;

use function Pest\Laravel\assertSoftDeleted;

test('delete procedure action', function () {
    $procedure = Procedure::factory()->create();

    $response = app(ProcedureDeleteAction::class)->execute($procedure);

    expect($response)->toBeTrue();

    assertSoftDeleted(Procedure::class, ['user_id' => $procedure->user_id]);
    assertSoftDeleted(User::class, ['id' => $procedure->user_id]);
});
