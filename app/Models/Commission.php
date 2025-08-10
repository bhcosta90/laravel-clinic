<?php

declare(strict_types = 1);

namespace App\Models;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Commission extends Model
{
    protected $fillable = [
        'user_id',
        'value',
        'due_date',
        'payment_date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
