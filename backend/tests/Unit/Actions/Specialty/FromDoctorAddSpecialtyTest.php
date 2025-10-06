<?php

declare(strict_types=1);

use App\Actions\Specialty\FromDoctorAddSpecialty;
use App\Models\Doctor;
use App\Models\Specialty;

use function Pest\Laravel\assertDatabaseCount;

test('adds specialty to a doctors', function () {
    $doctors = Doctor::factory()->create();
    $specialty = Specialty::factory()->create();

    app(FromDoctorAddSpecialty::class)->execute($specialty, [$doctors->id]);

    assertDatabaseCount('doctor_specialty', 1);
});

test('adds specialty to multiple doctor', function () {
    $doctors = Doctor::factory(3)->create();
    $specialty = Specialty::factory()->create();

    app(FromDoctorAddSpecialty::class)->execute($specialty, $doctors->pluck('id')->toArray());

    assertDatabaseCount('doctor_specialty', 3);
});

test('does not add specialty when doctors list is empty', function () {
    $specialty = Specialty::factory()->create();

    app(FromDoctorAddSpecialty::class)->execute($specialty, []);

    assertDatabaseCount('doctor_specialty', 0);
});
