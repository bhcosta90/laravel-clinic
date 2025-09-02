<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Packing extends Model
{
    use HasFactory;
    use SoftDeletes;

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
