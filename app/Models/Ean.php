<?php

declare(strict_types = 1);

namespace App\Models;

use App\Abstracts\Model;
use App\Enums\Models\Ean\UnitOfMeasure;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

final class Ean extends Model
{
    protected $table = 'ean';

    protected $fillable = [
        'ean',
        'gross_weight',
        'net_weight',
        'unit_of_measure',
        'volume',
        'model_id',
        'model_type',
    ];

    protected $casts = [
        'unit_of_measure' => UnitOfMeasure::class,
    ];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function packings(): HasMany
    {
        return $this->hasMany(Packing::class);
    }
}
