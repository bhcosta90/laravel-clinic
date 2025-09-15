<?php

declare(strict_types = 1);

namespace App\Models;

use App\Models\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class ModelPermission extends Model
{
    protected $table = 'model_permission';

    protected $fillable = [
        'model_id',
        'model_type',
        'permission_id',
    ];

    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class);
    }
}
