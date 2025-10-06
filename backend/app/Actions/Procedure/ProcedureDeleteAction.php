<?php

declare(strict_types=1);

namespace App\Actions\Procedure;

use App\Models\Procedure;

final class ProcedureDeleteAction
{
    public function execute(Procedure $model): bool
    {
        return $model->delete();
    }
}
