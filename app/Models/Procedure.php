<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class Procedure extends Eloquent\Model
{
    protected $fillable = [
        'code',
        'name',
        'min_duration_minutes',
        'max_duration_minutes',
    ];

    protected $casts = [
        'min_duration_minutes' => 'int',
        'max_duration_minutes' => 'int',
    ];

    /**
     * Doctors who can perform this procedure.
     */
    public function doctors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'procedure_user', 'procedure_id', 'user_id')->withTimestamps();
    }
}
