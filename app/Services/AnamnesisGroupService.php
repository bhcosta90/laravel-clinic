<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\AnamnesisGroup;

final class AnamnesisGroupService extends Service
{
    protected function model(): AnamnesisGroup
    {
        return new AnamnesisGroup();
    }

    protected function search(): array
    {
        return ['name'];
    }
}
