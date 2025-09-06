<?php

declare(strict_types = 1);

namespace App\Models;

use App\Abstracts\Model;
use App\Enums\Models\Barcode\Type;
use App\Traits\Models\DeletingTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Barcode extends Model
{
    use DeletingTrait;

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

    protected function fieldsUpdatedOnDelete(): array
    {
        return [
            'code',
        ];
    }
}
