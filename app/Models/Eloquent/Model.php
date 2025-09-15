<?php

declare(strict_types = 1);

namespace App\Models\Eloquent;

use App\Models\Traits\HashCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

abstract class Model extends \Illuminate\Database\Eloquent\Model implements Auditable
{
    use HasFactory;
    use HashCode;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
}
