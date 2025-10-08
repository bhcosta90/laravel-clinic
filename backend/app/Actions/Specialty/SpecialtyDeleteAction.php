<?php

declare(strict_types=1);

namespace App\Actions\Specialty;

use App\Models\Specialty;

final readonly class SpecialtyDeleteAction
{
    public function execute(Specialty $model): bool
    {
        return $model->delete();
    }
}
