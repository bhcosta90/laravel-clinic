<?php

declare(strict_types = 1);

return [
    'resolvers' => [
        'ip_address'          => OwenIt\Auditing\Resolvers\IpAddressResolver::class,
        'user_agent'          => OwenIt\Auditing\Resolvers\UserAgentResolver::class,
        'url'                 => OwenIt\Auditing\Resolvers\UrlResolver::class,
        'impersonate_user_id' => App\Repository\Auditing\ImpersonateResolver::class,
    ],

    'threshold' => 10,

    'queue' => [
        'enable'     => true,
        'connection' => 'sync',
        'queue'      => 'default',
        'delay'      => 0,
    ],
];
