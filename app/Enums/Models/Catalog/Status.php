<?php

declare(strict_types = 1);

namespace App\Enums\Models\Catalog;

enum Status: int
{
    case Enabled  = 1;
    case Disabled = 2;
}
