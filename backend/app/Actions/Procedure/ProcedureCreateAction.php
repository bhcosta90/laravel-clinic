<?php

declare(strict_types=1);

namespace App\Actions\Procedure;

use App\Models\Procedure;

final readonly class ProcedureCreateAction
{
    public function execute(string $name): Procedure
    {
        return Procedure::query()->create(['name' => $name]);
    }
}
