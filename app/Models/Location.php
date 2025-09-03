<?php

declare(strict_types = 1);

namespace App\Models;

use App\Abstracts\Model;
use App\Enums\Models\Location as EnumLocation;
use App\Traits\Models\UserTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Location extends Model
{
    use UserTrait;

    protected $fillable = [
        'code',
        'type',
        'aisle',
        'column',
        'level',
        'position',
        'zone',
        'max_capacity',
        'sequence',
        'control',
        'temperature',
        'status',
    ];

    protected $casts = [
        'type'    => EnumLocation\Type::class,
        'control' => EnumLocation\Control::class,
        'zone'    => EnumLocation\Zone::class,
        'status'  => EnumLocation\Status::class,
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
