<?php

declare(strict_types = 1);

namespace App\Models;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

final class Tenant extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
    ];
}
