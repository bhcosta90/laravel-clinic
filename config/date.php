<?php

declare(strict_types = 1);

return [
    // Start hour (24h) when generating available time slots in admin appointment create
    'hour_start' => env('APPOINTMENT_HOUR_START', 8),

    // End hour (24h, exclusive) when generating available time slots
    'hour_end' => env('APPOINTMENT_HOUR_END', 18),

    // Interval in minutes between time slots (e.g., 15, 20, 30, 60)
    'interval_minutes' => env('APPOINTMENT_INTERVAL_MINUTES', 15),
];
