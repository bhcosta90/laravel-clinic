<?php

declare(strict_types = 1);

namespace App\Services\Domain;

use App\Services\Domain\Scheduling\SchedulingCoordinator;
use App\Services\Domain\Scheduling\SchedulingRequest;
use App\Services\Domain\Scheduling\SchedulingServiceSetters;
use Carbon\Carbon;
use Illuminate\Support\Collection;

final class SchedulingService
{
    use SchedulingServiceSetters;

    private ?string $patientCode          = null;
    private ?int $doctorId                = null;
    private ?string $procedureCode        = null;
    private ?Carbon $minDate              = null;
    private int $daysToSearch             = 30;
    private int $defaultFirstVisitMinutes = 30;
    private ?int $desiredDurationMinutes  = null;
    private ?string $specialtyCode        = null;
    private ?int $maxSlots                = null;
    private ?string $roomCode             = null;
    private bool $requireRoom             = false;

    private SchedulingCoordinator $coordinator;

    public function __construct(?SchedulingCoordinator $coordinator = null)
    {
        $this->coordinator = $coordinator ?? app(SchedulingCoordinator::class);
    }

    /** Execute using the configured builder state. */
    public function find(): Collection
    {
        if (null === $this->patientCode || !$this->minDate instanceof Carbon) {
            return collect();
        }

        $req = new SchedulingRequest(
            patientCode: $this->patientCode,
            doctorId: $this->doctorId,
            procedureCode: $this->procedureCode,
            minDate: $this->minDate,
            daysToSearch: $this->daysToSearch,
            defaultFirstVisitMinutes: $this->defaultFirstVisitMinutes,
            desiredDurationMinutes: $this->desiredDurationMinutes,
            specialtyCode: $this->specialtyCode,
            maxSlots: $this->maxSlots,
            roomCode: $this->roomCode,
            requireRoom: $this->requireRoom,
        );

        return $this->coordinator->find($req);
    }
}
