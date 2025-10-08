<?php

declare(strict_types=1);

use App\Http\Controllers\SpecialtyController;
use App\Models\Specialty;

test('specialty index returns 200', function () {
    $response = $this->get(action([SpecialtyController::class, 'index']));
    $response->assertStatus(200);
});

test('specialty store returns 201', function () {
    $response = $this->post(action([SpecialtyController::class, 'store'], ['name' => 'Specialty Test']));
    $response->assertStatus(201);
});

test('specialty store with password returns 201 and hashes password', function () {
    $response = $this->post(action([SpecialtyController::class, 'store'], [
        'name' => 'Specialty Test',
    ]));
    $response->assertStatus(201);
});

test('specialty show returns 200', function () {
    $specialty = Specialty::factory()->create();

    $response = $this->get(action([SpecialtyController::class, 'show'], [
        'specialty' => $specialty->id,
    ]));
    $response->assertStatus(200);
});

test('specialty update returns 200', function () {
    $specialty = Specialty::factory()->create();

    $response = $this->put(action([SpecialtyController::class, 'update'], [
        'specialty' => $specialty->id,
        'name' => 'Specialty Test',
    ]));
    $response->assertStatus(200);
});

test('specialty destroy returns 204', function () {
    $specialty = Specialty::factory()->create();

    $response = $this->delete(action([SpecialtyController::class, 'destroy'], [
        'specialty' => $specialty->id,
    ]));
    $response->assertStatus(204);
});
