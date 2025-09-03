<?php

declare(strict_types = 1);

namespace App\Models;

use App\Abstracts\Model;
use App\Enums\Models\Error\Type;
use App\Traits\Models\UserTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Error extends Model
{
    use UserTrait;

    protected $fillable = [
        'type',
        'message',
        'data',
        'tenant_id',
        'user_id',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'type' => Type::class,
        ];
    }
}
