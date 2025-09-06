<?php

declare(strict_types = 1);

namespace App\Models;

use App\Abstracts\Model;
use App\Enums\Models\Barcode\Type;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Barcode extends Model
{
    protected $fillable = [
        'packing_id',
        'code',
        'type',
    ];

    protected $casts = [
        'type' => Type::class,
    ];

    public function packing(): BelongsTo
    {
        return $this->belongsTo(Packing::class);
    }
}
