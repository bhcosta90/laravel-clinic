<?php

declare(strict_types=1);

namespace App\Models;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

final class Tenant extends Model
{
    use HasUlids;
}
