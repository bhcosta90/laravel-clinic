<?php

declare(strict_types=1);

namespace App\Actions\Procedure;

use App\Models\Procedure;

final class ProcedureUpdateAction
{
    public function execute(Procedure $model, string $name): Procedure
    {
        return tap($model)->update(['name' => $name]);
    }
}
