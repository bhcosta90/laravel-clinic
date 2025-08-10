<?php

declare(strict_types=1);

namespace App\Models;

use App\Abstracts\Model;

final class Procedure extends Model
{
    protected $fillable = [
        'name',
        'price',
        'time',
        'description',
        'is_agreement',
        'is_exam',
    ];

    protected function casts(): array
    {
        return [
            'is_agreement' => 'boolean',
            'is_exam'      => 'boolean',
            'price'        => 'float',
        ];
    }
}
