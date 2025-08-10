<?php

declare(strict_types = 1);

namespace App\Models;

use App\Abstracts\Model;
use App\Casts\OnlyNumberCast;

final class Agreement extends Model
{
    protected $fillable = [
        'name',
        'cellphone',
        'commission',
    ];

    protected $casts = [
        'cellphone' => OnlyNumberCast::class,
    ];
}
