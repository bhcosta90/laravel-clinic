<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class Specialty extends Eloquent\Model
{
    protected $fillable = [
        'code',
        'name',
    ];

    public function doctors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'specialty_user', 'specialty_id', 'user_id')->withTimestamps();
    }
}
