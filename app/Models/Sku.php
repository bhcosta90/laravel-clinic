<?php

declare(strict_types = 1);

namespace App\Models;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

final class Sku extends Model
{
    protected $fillable = [
        'sku_code',
        'barcode',
        'description',
        'unit_of_measure',
        'conversion_factor',
        'weight',
        'volume',
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
