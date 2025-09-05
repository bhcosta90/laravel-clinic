<?php

declare(strict_types = 1);

namespace App\Models;

use App\Abstracts\Model;
use App\Enums\Models\Catalog\Hazardous;
use App\Enums\Models\Catalog\Status;
use App\Enums\Models\Catalog\TrackingMode;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

final class Catalog extends Model
{
    protected $fillable = [
        'tenant_id',
        'name',
        'tracking_mode',
        'hazardous',
        'temperature_controlled',
        'status',
    ];

    protected $casts = [
        'temperature_controlled' => 'boolean',
        'tracking_mode'          => TrackingMode::class,
        'hazardous'              => Hazardous::class,
        'status'                 => Status::class,
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function ean(): MorphMany
    {
        return $this->morphMany(Ean::class, 'model');
    }
}
