<?php

declare(strict_types = 1);

namespace App\Models;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Warehouse extends Model
{
    protected $fillable = [
        'name',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
