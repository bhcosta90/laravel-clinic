<?php

declare(strict_types = 1);

namespace App\Enums\Queue;

enum Queue: string
{
    case Low      = 'low';
    case Priority = 'priority';
    case Long     = 'long';
    case Medium   = 'medium';
    case Report   = 'report';
}
