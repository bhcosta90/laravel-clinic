<?php

declare(strict_types = 1);

namespace App\Models;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Packing extends Model
{
    protected $fillable = [
        'sku_id',
        'unit_of_measure',
        'unit_of_measure',
        'dun14',
        'sscc',
        'gross_weight',
        'net_weight',
        'volume',
    ];

    public function sku(): BelongsTo
    {
        return $this->belongsTo(Sku::class);
    }
}
