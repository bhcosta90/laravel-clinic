<?php

declare(strict_types = 1);

use App\Services\Domain\Scheduling\Availability;
use Carbon\Carbon;

it('detects clinic blocks, doctor availability, patient conflicts and room availability', function (): void {
    $a = new Availability();

    // clinic blocks
    $clinicBlocks = collect([(object) ['start_at' => '2025-09-01 09:30:00', 'end_at' => '2025-09-01 10:30:00']]);
    expect($a->isClinicBlocked($clinicBlocks, Carbon::parse('2025-09-01 09:45:00'), Carbon::parse('2025-09-01 10:00:00')))->toBeTrue();
    expect($a->isClinicBlocked($clinicBlocks, Carbon::parse('2025-09-01 08:00:00'), Carbon::parse('2025-09-01 09:00:00')))->toBeFalse();

    // doctor availability
    $doctorBlocks = collect([1 => collect([(object) ['start_at' => '2025-09-01 09:00:00', 'end_at' => '2025-09-01 09:30:00']])]);
    $apptByDoc    = collect([1 => collect([(object) ['start_at' => '2025-09-01 10:00:00', 'end_at' => '2025-09-01 10:30:00']])]);
    expect($a->isDoctorAvailable($doctorBlocks, $apptByDoc, 1, Carbon::parse('2025-09-01 09:15:00'), Carbon::parse('2025-09-01 09:25:00')))->toBeFalse();
    expect($a->isDoctorAvailable($doctorBlocks, $apptByDoc, 1, Carbon::parse('2025-09-01 09:31:00'), Carbon::parse('2025-09-01 09:59:00')))->toBeTrue();
    expect($a->isDoctorAvailable($doctorBlocks, $apptByDoc, 1, Carbon::parse('2025-09-01 10:15:00'), Carbon::parse('2025-09-01 10:25:00')))->toBeFalse();

    // patient conflicts
    $patientAppointments = collect([(object) ['start_at' => '2025-09-01 11:00:00', 'end_at' => '2025-09-01 12:00:00']]);
    expect($a->patientConflicts($patientAppointments, Carbon::parse('2025-09-01 11:30:00'), Carbon::parse('2025-09-01 11:45:00')))->toBeTrue();
    expect($a->patientConflicts($patientAppointments, Carbon::parse('2025-09-01 12:00:00'), Carbon::parse('2025-09-01 12:30:00')))->toBeFalse();

    // room availability
    $roomBlocks = collect([2 => collect([(object) ['start_at' => '2025-09-01 09:00:00', 'end_at' => '2025-09-01 09:15:00']])]);
    $apptByRoom = collect([2 => collect([(object) ['start_at' => '2025-09-01 09:30:00', 'end_at' => '2025-09-01 10:00:00']])]);
    expect($a->isRoomAvailable($roomBlocks, $apptByRoom, 2, Carbon::parse('2025-09-01 09:15:00'), Carbon::parse('2025-09-01 09:30:00')))->toBeTrue();
    expect($a->isRoomAvailable($roomBlocks, $apptByRoom, 2, Carbon::parse('2025-09-01 09:30:00'), Carbon::parse('2025-09-01 09:45:00')))->toBeFalse();
});
