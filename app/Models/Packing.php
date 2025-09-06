<?php

declare(strict_types = 1);

namespace App\Models;

use App\Abstracts\Model;
use App\Enums\Models\Packing\Level;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Packing extends Model
{
    use HasUlids;

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

    public function barcodes(): HasMany
    {
        return $this->hasMany(Barcode::class);
    }
}
