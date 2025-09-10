<?php

declare(strict_types = 1);

namespace App\Models;

final class ClinicUnavailability extends Eloquent\Model
{
    protected $fillable = [
        'start_at',
        'end_at',
        'reason',
    ];
}
