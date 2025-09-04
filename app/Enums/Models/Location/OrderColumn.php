<?php

declare(strict_types = 1);

namespace App\Enums\Models\Location;

enum OrderColumn
{
    case EvenOdd;
    case OddEven;
    case Sequence;
}
