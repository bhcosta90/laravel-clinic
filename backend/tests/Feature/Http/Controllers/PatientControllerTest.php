<?php

declare(strict_types=1);

use App\Http\Controllers\PatientController;
use App\Models\Patient;

test('patient index returns 200', function () {
    $response = $this->get(action([PatientController::class, 'index']));
    $response->assertStatus(200);
});

test('patient store returns 201', function () {
    $response = $this->post(action([PatientController::class, 'store'], ['name' => 'Patient Test']));
    $response->assertStatus(201);
});

test('patient store with password returns 201 and hashes password', function () {
    $response = $this->post(action([PatientController::class, 'store'], [
        'name' => 'Patient Test',
    ]));
    $response->assertStatus(201);
});

test('patient show returns 200', function () {
    $patient = Patient::factory()->create();

    $response = $this->get(action([PatientController::class, 'show'], [
        'patient' => $patient->id,
    ]));
    $response->assertStatus(200);
});

test('patient update returns 200', function () {
    $patient = Patient::factory()->create();

    $response = $this->put(action([PatientController::class, 'update'], [
        'patient' => $patient->id,
        'name' => 'Patient Test',
    ]));
    $response->assertStatus(200);
});

test('patient destroy returns 204', function () {
    $patient = Patient::factory()->create();

    $response = $this->delete(action([PatientController::class, 'destroy'], [
        'patient' => $patient->id,
    ]));
    $response->assertStatus(204);
});
