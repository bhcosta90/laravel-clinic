<?php

declare(strict_types = 1);

return [
    'queue' => [
        'enable'     => true,
        'connection' => env('QUEUE_CONNECTION', 'sync'),
        'queue'      => env('AUDITING_QUEUE', 'audit'),
        'delay'      => 0,
    ],
    'console' => true,
];
