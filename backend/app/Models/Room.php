<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\RoomFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Room extends Model
{
    /** @use HasFactory<RoomFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function timeOff(): HasMany
    {
        return $this->hasMany(RoomTimeOff::class);
    }
}
