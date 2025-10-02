<?php

declare(strict_types = 1);

namespace Core\Domain\Enum;

enum DayEnum: int
{
    case Monday    = 0;
    case Tuesday   = 1;
    case Wednesday = 2;
    case Thursday  = 3;
    case Friday    = 4;
    case Saturday  = 5;
    case Sunday    = 6;
}
