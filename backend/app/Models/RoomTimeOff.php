<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class RoomTimeOff extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'room_id',
        'start_at',
        'end_at',
        'reason',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function timeOff(): HasMany
    {
        return $this->hasMany(self::class);
    }
}
