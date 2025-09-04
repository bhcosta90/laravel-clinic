<?php

declare(strict_types = 1);

namespace App\Models;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class LocationModule extends Model
{
    protected $fillable = [
        'tenant_id',
        'acronym',
        'sequence',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
