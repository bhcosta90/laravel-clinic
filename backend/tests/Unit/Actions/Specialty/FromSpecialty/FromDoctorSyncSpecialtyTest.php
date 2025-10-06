<?php

declare(strict_types=1);

use App\Actions\Specialty\FromDoctor\FromDoctorSyncSpecialty;
use App\Models\Doctor;
use App\Models\Specialty;
use function Pest\Laravel\assertDatabaseCount;

test('sync specialty from a doctors', function () {
    $doctors = Doctor::factory()->create();
    $specialty = Specialty::factory()->hasAttached($doctors)->create();

    app(FromDoctorSyncSpecialty::class)->execute($specialty, [$doctors->id]);

    assertDatabaseCount('doctor_specialty', 1);
});

test('sync specialty from multiple doctors', function () {
    $doctors = Doctor::factory(3)->create();
    $specialty = Specialty::factory()->hasAttached($doctors)->create();

    app(FromDoctorSyncSpecialty::class)->execute($specialty, [$doctors->get(0)->id]);

    assertDatabaseCount('doctor_specialty', 1);
});

test('does not sync specialty when doctors list is empty', function () {
    $doctors = Doctor::factory(1)->create();
    $specialty = Specialty::factory()->hasAttached($doctors)->create();

    app(FromDoctorSyncSpecialty::class)->execute($specialty, []);

    assertDatabaseCount('doctor_specialty', 0);
});
