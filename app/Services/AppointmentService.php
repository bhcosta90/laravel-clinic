<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Appointment;

final class AppointmentService extends Service
{
    protected function model(): Appointment
    {
        return new Appointment();
    }

    protected function search(): array
    {
        return ['date'];
    }
}
