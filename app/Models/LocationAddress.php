<?php

declare(strict_types = 1);

namespace App\Models;

use App\Traits\Models\CastsDatesToUserTimezone;
use App\Traits\Models\HashCode;
use App\Traits\Models\TenantTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

final class LocationAddress extends Model implements Auditable
{
    use CastsDatesToUserTimezone;
    use HasFactory;
    use HashCode;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use TenantTrait;

    protected $fillable = [
        'location_id',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
