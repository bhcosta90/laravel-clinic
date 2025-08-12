<?php

declare(strict_types = 1);

namespace App\Models;

use App\Abstracts\Model;
use App\Enums\Models\Report\Status;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

final class Report extends Model
{
    protected $fillable = [
        'name',
        'status',
        'model',
        'user_id',
        'view',
        'filters',
    ];

    public function fileUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => when($this->file, fn () => Storage::url($this->file)),
        );
    }

    protected function casts(): array
    {
        return [
            'key'     => 'string',
            'status'  => Status::class,
            'filters' => 'array',
        ];
    }
}
