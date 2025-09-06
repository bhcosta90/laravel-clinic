<?php

declare(strict_types = 1);

namespace App\Models;

use App\Abstracts\Model;
use App\Enums\Models\Packing\Level;

final class Packing extends Model
{
    protected $fillable = [
        'model_type',
        'model_id',
        'level',
        'quantity',
        'weight',
        'length',
        'width',
        'height',
    ];

    protected $casts = [
        'level' => Level::class,
    ];
}
