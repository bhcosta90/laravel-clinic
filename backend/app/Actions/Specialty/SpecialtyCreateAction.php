<?php

declare(strict_types=1);

namespace App\Actions\Specialty;

use App\Models\Specialty;

final class SpecialtyCreateAction
{
    public function execute(string $name): Specialty
    {
        return Specialty::create(compact('name'));
    }
}
