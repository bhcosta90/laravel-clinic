<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Appointment;
use Illuminate\Container\Attributes\CurrentUser;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;

final class AppointmentService extends Service
{
    protected function model(): Appointment
    {
        return new Appointment();
    }

    protected function index(string $search, ?array $filters = [])
    {
        // Includes common relations for listing appointments
        $includes = [
            'user' => [],
            'customer' => [],
            'procedure' => [],
            'agreement' => [],
        ];

        return app(BuilderQuery::class)->execute(new Appointment(), $includes, [
            // generic filter by related names if the builder supports it; otherwise, search is optional
            '(byFilter)' => $search,
        ] + ($filters ?: []));
    }
}
