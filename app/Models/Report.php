<?php

declare(strict_types=1);

namespace App\Models;

use App\Abstracts\Model;
use App\Enums\Models\Report\Status;

final class Report extends Model
{
    protected $fillable = [
        'key',
        'name',
        'status',
        'model',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'key'    => 'string',
            'status' => Status::class,
        ];
    }
}
