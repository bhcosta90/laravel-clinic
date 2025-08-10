<?php

declare(strict_types=1);

namespace App\Models;

use App\Abstracts\Model;

final class Frequency extends Model
{
    protected $fillable = [
        'name',
        'days',
    ];
}
