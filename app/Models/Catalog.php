<?php

declare(strict_types = 1);

namespace App\Models;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Catalog extends Model
{
    protected $fillable = [
        'tenant_id',
        'name',
        'tracking_mode',
        'hazardous',
        'temperature_controlled',
        'status',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
