<?php

declare(strict_types = 1);

namespace App\Models;

use App\Models\Eloquent\Model;

final class Permission extends Model
{
    protected $fillable = [
        'slug',
    ];
}
