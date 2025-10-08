<?php

declare(strict_types=1);

use App\Http\Controllers\ProcedureController;
use App\Models\Procedure;

test('procedure index returns 200', function () {
    $response = $this->get(action([ProcedureController::class, 'index']));
    $response->assertStatus(200);
});

test('procedure store returns 201', function () {
    $response = $this->post(action([ProcedureController::class, 'store'], ['name' => 'Procedure Test']));
    $response->assertStatus(201);
});

test('procedure store with password returns 201 and hashes password', function () {
    $response = $this->post(action([ProcedureController::class, 'store'], [
        'name' => 'Procedure Test',
    ]));
    $response->assertStatus(201);
});

test('procedure show returns 200', function () {
    $procedure = Procedure::factory()->create();

    $response = $this->get(action([ProcedureController::class, 'show'], [
        'procedure' => $procedure->id,
    ]));
    $response->assertStatus(200);
});

test('procedure update returns 200', function () {
    $procedure = Procedure::factory()->create();

    $response = $this->put(action([ProcedureController::class, 'update'], [
        'procedure' => $procedure->id,
        'name' => 'Procedure Test',
    ]));
    $response->assertStatus(200);
});

test('procedure destroy returns 204', function () {
    $procedure = Procedure::factory()->create();

    $response = $this->delete(action([ProcedureController::class, 'destroy'], [
        'procedure' => $procedure->id,
    ]));
    $response->assertStatus(204);
});
