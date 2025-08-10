<?php

declare(strict_types = 1);

namespace App\Models;

use App\Abstracts\Model;
use App\Enums\Models\Transaction as TransactionEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Transaction extends Model
{
    protected $fillable = [
        'customer_id',
        'payment_method_id',
        'value',
        'due_date',
        'type',
        'payment_date',
        'frequency',
        'description',
        'name',
        'user_id',
        'agreement_id',
        'model_type',
        'model_id',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function agreement(): BelongsTo
    {
        return $this->belongsTo(Agreement::class);
    }

    protected function casts(): array
    {
        return [
            'due_date'     => 'date',
            'payment_date' => 'date',
            'type'         => TransactionEnum\Type::class,
            'frequency'    => 'integer',
        ];
    }
}
