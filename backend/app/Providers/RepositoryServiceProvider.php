<?php

declare(strict_types = 1);

namespace App\Providers;

use Core\Application\Repository as ApplicationRepository;
use Core\Domain\Repository as DomainRepository;
use Illuminate\Support\ServiceProvider;

final class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(DomainRepository\ProcedureRepositoryInterface::class, ApplicationRepository\ProcedureRepository::class);
        $this->app->singleton(DomainRepository\SpecialtyRepositoryInterface::class, ApplicationRepository\SpecialtyRepository::class);
        $this->app->singleton(DomainRepository\PatientRepositoryInterface::class, ApplicationRepository\PatientRepository::class);
        $this->app->singleton(DomainRepository\RoomRepositoryInterface::class, ApplicationRepository\RoomRepository::class);
        $this->app->singleton(DomainRepository\DoctorRepositoryInterface::class, ApplicationRepository\DoctorRepository::class);
    }
}
