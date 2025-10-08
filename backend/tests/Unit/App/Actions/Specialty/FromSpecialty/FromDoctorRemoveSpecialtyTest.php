<?php

declare(strict_types=1);

use App\Actions\Specialty\FromDoctor\FromDoctorRemoveSpecialty;
use App\Models\Doctor;
use App\Models\Specialty;

use function Pest\Laravel\assertDatabaseCount;

test('remove specialty from a doctors', function () {
    $doctors = Doctor::factory()->create();
    $specialty = Specialty::factory()->hasAttached($doctors)->create();

    app(FromDoctorRemoveSpecialty::class)->execute($specialty, [$doctors->id]);

    assertDatabaseCount('doctor_specialty', 0);
});

test('remove specialty from multiple doctors', function () {
    $doctors = Doctor::factory(3)->create();
    $specialty = Specialty::factory()->hasAttached($doctors)->create();

    app(FromDoctorRemoveSpecialty::class)->execute($specialty, [$doctors->get(0)->id]);

    assertDatabaseCount('doctor_specialty', 2);
});

test('does not remove specialty when doctors list is empty', function () {
    $doctors = Doctor::factory(1)->create();
    $specialty = Specialty::factory()->hasAttached($doctors)->create();

    app(FromDoctorRemoveSpecialty::class)->execute($specialty, []);

    assertDatabaseCount('doctor_specialty', 1);
});
