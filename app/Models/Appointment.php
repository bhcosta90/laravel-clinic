<?php

declare(strict_types = 1);

namespace App\Models;

use App\Abstracts\Model;
use App\Enums\Models\Appointment\Status;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

final class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'procedure_id',
        'customer_id',
        'date',
        'is_return',
        'date_retired',
        'exam_withdrawal_date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function procedure(): BelongsTo
    {
        return $this->belongsTo(Procedure::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function agreement(): BelongsTo
    {
        return $this->belongsTo(Agreement::class);
    }

    #[Scope]
    public function byDate(Builder $builder, Collection $dates): void
    {
        $builder->whereDate('date', '=', $dates->first());
    }

    public function statusDescription(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status?->label() ?? 'Pending',
        );
    }

    protected function casts(): array
    {
        return [
            'date'      => 'datetime',
            'is_return' => 'boolean',
            'status'    => Status::class,
        ];
    }
}
