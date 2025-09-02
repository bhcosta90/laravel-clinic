<?php

declare(strict_types = 1);

namespace App\Models;

use App\Abstracts\Model;
use App\Enums\Models\Location as EnumLocation;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Location extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $fillable = [
        'code',
        'type',
        'warehouse',
        'aisle',
        'column',
        'level',
        'position',
        'zone',
        'location_type',
        'max_capacity',
        'picking_sequence',
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
