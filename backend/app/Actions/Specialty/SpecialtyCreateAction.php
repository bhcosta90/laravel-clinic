<?php

declare(strict_types=1);

namespace App\Actions\Specialty;

use App\Models\Specialty;

final readonly class SpecialtyCreateAction
{
    public function execute(string $name): Specialty
    {
        return Specialty::query()->create(['name' => $name]);
    }
}
