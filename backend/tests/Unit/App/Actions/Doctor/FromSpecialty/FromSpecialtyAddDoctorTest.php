<?php

declare(strict_types=1);

use App\Actions\Doctor\FromSpecialty\FromSpecialtyAddDoctor;
use App\Models\Doctor;
use App\Models\Specialty;

use function Pest\Laravel\assertDatabaseCount;

test('adds doctor to a specialties', function () {
    $specialties = Specialty::factory()->create();
    $doctor = Doctor::factory()->create();

    app(FromSpecialtyAddDoctor::class)->execute($doctor, [$specialties->id]);

    assertDatabaseCount('doctor_specialty', 1);
});

test('adds doctor to multiple doctor', function () {
    $specialties = Specialty::factory(3)->create();
    $doctor = Doctor::factory()->create();

    app(FromSpecialtyAddDoctor::class)->execute($doctor, $specialties->pluck('id')->toArray());

    assertDatabaseCount('doctor_specialty', 3);
});

test('does not add doctor when specialties list is empty', function () {
    $doctor = Doctor::factory()->create();

    app(FromSpecialtyAddDoctor::class)->execute($doctor, []);

    assertDatabaseCount('doctor_specialty', 0);
});
