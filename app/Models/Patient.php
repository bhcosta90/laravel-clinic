<?php

declare(strict_types = 1);

namespace App\Models;

final class Patient extends Eloquent\Model
{
    protected $fillable = [
        'code',
        'name',
    ];
}
