<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\AnamnesisItem;

final class AnamnesisItemService extends Service
{
    protected function model(): AnamnesisItem
    {
        return new AnamnesisItem();
    }

    protected function search(): array
    {
        return ['name'];
    }
}
