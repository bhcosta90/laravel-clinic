<?php

declare(strict_types = 1);

namespace App\Models;

use App\Abstracts\Model;
use App\Enums\Models\Catalog\Hazardous;
use App\Enums\Models\Catalog\Status;
use App\Enums\Models\Catalog\TrackingMode;

final class Catalog extends Model
{
    protected $fillable = [
        'name',
        'tracking_mode',
        'status',
        'hazardous',
    ];

    protected $casts = [
        'tracking_mode' => TrackingMode::class,
        'status'        => Status::class,
        'hazardous'     => Hazardous::class,
    ];
}
