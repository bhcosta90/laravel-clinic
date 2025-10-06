<?php

declare(strict_types=1);

namespace App\Actions\Specialty;

use App\Models\Specialty;

final class SpecialtyUpdateAction
{
    public function execute(Specialty $model, string $name): Specialty
    {
        return tap($model)->update(compact('name'));
    }
}
