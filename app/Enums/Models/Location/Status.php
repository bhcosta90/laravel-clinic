<?php

declare(strict_types = 1);

namespace App\Enums\Models\Location;

enum Status: int
{
    case Enabled  = 1;
    case Disabled = 2;
    case Blocked  = 3;
}
