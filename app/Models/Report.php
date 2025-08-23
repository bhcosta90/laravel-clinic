<?php

declare(strict_types = 1);

namespace App\Models;

use App\Abstracts\Model;
use App\Enums\Models\Report\Status;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

final class Report extends Model
{
    use HasUlids;

    protected $fillable = [
        'name',
        'status',
        'model',
        'user_id',
        'view',
        'filters',
        'filesystem',
        'can_shared',
    ];

    public function fileUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => when($this->file, fn () => route('report.view-file', $this->code)),
        );
    }

    public function uniqueIds(): array
    {
        return [
            'code',
        ];
    }

    protected function casts(): array
    {
        return [
            'key'        => 'string',
            'status'     => Status::class,
            'filters'    => 'array',
            'can_shared' => 'boolean',
        ];
    }
}
