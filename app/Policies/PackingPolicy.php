<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Enums\Models\Permission\Can;
use App\Policies\Traits\CrudPolicyTrait;

final class PackingPolicy
{
    use CrudPolicyTrait;

    protected function getViewPermission(): Can
    {
        return Can::StockCatalogView;
    }

    protected function getEditPermission(): Can
    {
        return Can::StockCatalogEdit;
    }
}
