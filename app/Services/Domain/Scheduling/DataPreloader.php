<?php

declare(strict_types = 1);

namespace App\Services\Domain\Scheduling;

use App\Models\Appointment;
use App\Models\ClinicUnavailability;
use App\Models\DoctorUnavailability;
use App\Models\Room;
use App\Models\RoomUnavailability;
use Carbon\Carbon;
use Illuminate\Support\Collection;

final class DataPreloader
{
    /** @return array{clinicBlocks: Collection, doctorBlocksByDoc: Collection, appointmentsByDoc: Collection, rooms: Collection, roomBlocksByRoom: Collection, appointmentsByRoom: Collection, patientAppointments: Collection} */
    public function preload(array $doctorIds, array $roomIds, int $patientId, Carbon $minDate, Carbon $endSearch): array
    {
        $clinicBlocks = ClinicUnavailability::query()
            ->where('start_at', '<', $endSearch)
            ->where('end_at', '>', $minDate)
            ->get(['start_at', 'end_at']);

        $doctorBlocksByDoc = collect();

        if ([] !== $doctorIds) {
            $doctorBlocksByDoc = DoctorUnavailability::query()
                ->whereIn('doctor_id', $doctorIds)
                ->where('start_at', '<', $endSearch)
                ->where('end_at', '>', $minDate)
                ->get(['doctor_id', 'start_at', 'end_at'])
                ->groupBy('doctor_id');
        }

        $appointmentsByDoc = collect();

        if ([] !== $doctorIds) {
            $appointmentsByDoc = Appointment::query()
                ->whereIn('doctor_id', $doctorIds)
                ->where('start_at', '<', $endSearch)
                ->where('end_at', '>', $minDate)
                ->get(['doctor_id', 'start_at', 'end_at', 'room_id'])
                ->groupBy('doctor_id');
        }

        $rooms = collect();

        if ([] !== $roomIds) {
            $rooms = Room::query()->where('is_active', true)->whereIn('id', $roomIds)->get(['id', 'code']);
        }

        $roomBlocksByRoom = collect();

        if ([] !== $roomIds) {
            $roomBlocksByRoom = RoomUnavailability::query()
                ->whereIn('room_id', $roomIds)
                ->where('start_at', '<', $endSearch)
                ->where('end_at', '>', $minDate)
                ->get(['room_id', 'start_at', 'end_at'])
                ->groupBy('room_id');
        }

        $appointmentsByRoom = collect();

        if ([] !== $roomIds) {
            $appointmentsByRoom = Appointment::query()
                ->whereIn('room_id', $roomIds)
                ->where('start_at', '<', $endSearch)
                ->where('end_at', '>', $minDate)
                ->get(['room_id', 'start_at', 'end_at'])
                ->groupBy('room_id');
        }

        $patientAppointments = Appointment::query()
            ->where('patient_id', $patientId)
            ->where('start_at', '<', $endSearch)
            ->where('end_at', '>', $minDate)
            ->get(['start_at', 'end_at']);

        return ['clinicBlocks' => $clinicBlocks, 'doctorBlocksByDoc' => $doctorBlocksByDoc, 'appointmentsByDoc' => $appointmentsByDoc, 'rooms' => $rooms, 'roomBlocksByRoom' => $roomBlocksByRoom, 'appointmentsByRoom' => $appointmentsByRoom, 'patientAppointments' => $patientAppointments];
    }
}
