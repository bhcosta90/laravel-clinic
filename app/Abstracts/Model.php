<?php

declare(strict_types = 1);

namespace App\Abstracts;

use App\Models\Scopes\TenantScope;
use App\Traits\Models\CastsDatesToUserTimezone;
use App\Traits\Models\HashCode;
use App\Traits\Models\TenantTrait;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

#[ScopedBy(TenantScope::class)]
abstract class Model extends \Illuminate\Database\Eloquent\Model implements Auditable
{
    use CastsDatesToUserTimezone;
    use HasFactory;
    use HashCode;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use TenantTrait;
}
