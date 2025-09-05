<?php

declare(strict_types = 1);

namespace App\Models;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

final class Ean extends Model
{
    protected $table = 'ean';

    protected $fillable = [
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
