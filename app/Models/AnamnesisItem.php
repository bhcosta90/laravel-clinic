<?php

declare(strict_types = 1);

namespace App\Models;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class AnamnesisItem extends Model
{
    protected $fillable = [
        'name',
        'anamnesis_group_id',
        'description',
    ];

    public function anamnesisGroup(): BelongsTo
    {
        return $this->belongsTo(AnamnesisGroup::class);
    }
}
