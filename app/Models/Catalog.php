<?php

declare(strict_types = 1);

namespace App\Models;

use App\Abstracts\Model;
use App\Enums\Models\Catalog\Hazardous;
use App\Enums\Models\Catalog\Level;
use App\Enums\Models\Catalog\Status;
use App\Enums\Models\Catalog\TrackingMode;
use Illuminate\Database\Eloquent\Relations\MorphMany;

final class Catalog extends Model
{
    protected $fillable = [
        'name',
        'sku_code',
        'tracking_mode',
        'status',
        'hazardous',
    ];

    protected $casts = [
        'level'         => Level::class,
        'tracking_mode' => TrackingMode::class,
        'status'        => Status::class,
        'hazardous'     => Hazardous::class,
    ];

    public function packings(): MorphMany
    {
        return $this->morphMany(Packing::class, 'model');
    }
}
