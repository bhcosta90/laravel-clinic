<?php

declare(strict_types = 1);

namespace App\Enums\Models\Location;

use App\Traits\Enums\EnumHelpers;

enum Status: int
{
    use EnumHelpers;

    case Enabled  = 1;
    case Disabled = 2;
    case Blocked  = 3;
}
