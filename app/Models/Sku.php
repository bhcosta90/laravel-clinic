<?php

declare(strict_types = 1);

namespace App\Models;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function product(): BelongsTo
    {
        return $this->belongsTo(Catalog::class);
    }
}
