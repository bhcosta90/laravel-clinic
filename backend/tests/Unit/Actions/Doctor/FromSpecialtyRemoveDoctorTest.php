<?php

declare(strict_types=1);

use App\Actions\Doctor\FromSpecialtyRemoveDoctor;
use App\Models\Doctor;
use App\Models\Specialty;

use function Pest\Laravel\assertDatabaseCount;

test('remove specialty from a doctors', function () {
    $specialties = Specialty::factory()->create();
    $doctor = Doctor::factory()->hasAttached($specialties)->create();

    app(FromSpecialtyRemoveDoctor::class)->execute($doctor, [$specialties->id]);

    assertDatabaseCount('doctor_specialty', 0);
});

test('remove specialty from multiple doctors', function () {
    $specialties = Specialty::factory(3)->create();
    $doctor = Doctor::factory()->hasAttached($specialties)->create();

    app(FromSpecialtyRemoveDoctor::class)->execute($doctor, [$specialties->get(0)->id]);

    assertDatabaseCount('doctor_specialty', 2);
});

test('does not remove specialty when doctors list is empty', function () {
    $specialties = Specialty::factory(1)->create();
    $doctor = Doctor::factory()->hasAttached($specialties)->create();

    app(FromSpecialtyRemoveDoctor::class)->execute($doctor, []);

    assertDatabaseCount('doctor_specialty', 1);
});
