<?php

declare(strict_types=1);

use App\Http\Controllers\DoctorController;
use App\Models\Doctor;

test('doctor index returns 200', function () {
    $response = $this->get(action([DoctorController::class, 'index']));
    $response->assertStatus(200);
});

test('doctor store returns 201', function () {
    $response = $this->post(action([DoctorController::class, 'store'], ['name' => 'Shared Test', 'crm' => '123456']));
    $response->assertStatus(201);
});

test('doctor store with password returns 201 and hashes password', function () {
    $response = $this->post(action([DoctorController::class, 'store'], [
        'name' => 'Shared Test',
        'crm' => '123456',
        'password' => 'secret123',
    ]));
    $response->assertStatus(201);

    $doctor = Doctor::query()->where('crm', '123456')->first();
    expect(Illuminate\Support\Facades\Hash::check('secret123', $doctor->user->password))->toBeTrue();
});

test('doctor show returns 200', function () {
    $doctor = Doctor::factory()->create();

    $response = $this->get(action([DoctorController::class, 'show'], [
        'doctor' => $doctor->id,
    ]));
    $response->assertStatus(200);
});

test('doctor update returns 200', function () {
    $doctor = Doctor::factory()->create();

    $response = $this->put(action([DoctorController::class, 'update'], [
        'doctor' => $doctor->id,
        'name' => 'Shared Test',
        'crm' => '123456',
    ]));
    $response->assertStatus(200);
});

test('doctor destroy returns 204', function () {
    $doctor = Doctor::factory()->create();

    $response = $this->delete(action([DoctorController::class, 'destroy'], [
        'doctor' => $doctor->id,
    ]));
    $response->assertStatus(204);
});
