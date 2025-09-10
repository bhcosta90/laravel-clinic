<?php

declare(strict_types = 1);

namespace App\Models;

final class Room extends Eloquent\Model
{
    protected $fillable = [
        'code',
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
