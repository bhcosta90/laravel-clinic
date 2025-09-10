<?php

declare(strict_types = 1);

namespace App\Services\Domain\Scheduling;

use Carbon\Carbon;

trait SchedulingServiceSetters
{
    public function setPatientCode(string $code): self
    {
        $this->patientCode = $code;

        return $this;
    }

    public function setDoctorId(?int $doctorId): self
    {
        $this->doctorId = $doctorId;

        return $this;
    }

    public function setProcedureCode(?string $procedureCode): self
    {
        $this->procedureCode = $procedureCode;

        return $this;
    }

    public function setMinDate(Carbon $minDate): self
    {
        $this->minDate = $minDate;

        return $this;
    }

    public function setDaysToSearch(int $days): self
    {
        $this->daysToSearch = $days;

        return $this;
    }

    public function setDefaultFirstVisitMinutes(int $minutes): self
    {
        $this->defaultFirstVisitMinutes = $minutes;

        return $this;
    }

    public function setDesiredDurationMinutes(?int $minutes): self
    {
        $this->desiredDurationMinutes = $minutes;

        return $this;
    }

    public function setSpecialtyCode(?string $code): self
    {
        $this->specialtyCode = $code;

        return $this;
    }

    public function setMaxSlots(?int $max): self
    {
        $this->maxSlots = $max;

        return $this;
    }

    public function setRoomCode(?string $code): self
    {
        $this->roomCode = $code;

        return $this;
    }

    public function setRequireRoom(bool $require): self
    {
        $this->requireRoom = $require;

        return $this;
    }
}
