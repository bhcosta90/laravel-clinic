<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\SpecialtyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Specialty extends Model
{
    /** @use HasFactory<SpecialtyFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function doctors(): BelongsToMany
    {
        return $this->belongsToMany(Doctor::class);
    }
}
