<?php

declare(strict_types = 1);

return [
    'connections' => [
        'code' => [
            'salt'     => env('SALT_HASH_CODE', 'fd8c51c8-0dcb-44ad-9bde-ec0793bafc82'),
            'length'   => 6,
            'alphabet' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890',
        ],
    ],
];
