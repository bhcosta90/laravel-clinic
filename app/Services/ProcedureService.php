<?php

declare(strict_types = 1);

namespace App\Services;

use App\Models\Procedure;
use Costa\Service\Service;
use Override;

final class ProcedureService extends Service
{
    protected function model(): Procedure
    {
        return new Procedure();
    }

    protected function search(): array
    {
        return ['code', 'name'];
    }

    #[Override]
    protected function serializeData(array $data): array
    {
        if ($data['max_duration_minutes'] < $data['min_duration_minutes']) {
            [$data['min_duration_minutes'], $data['max_duration_minutes']] = [
                $data['max_duration_minutes'],
                $data['min_duration_minutes'],
            ];
        }

        return $data;
    }
}
