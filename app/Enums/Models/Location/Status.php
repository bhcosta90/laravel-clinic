<?php

declare(strict_types = 1);

namespace App\Enums\Models\Location;

enum Status: int
{
    case Active   = 1;
    case Inactive = 2;
    case Blocked  = 3;
}
