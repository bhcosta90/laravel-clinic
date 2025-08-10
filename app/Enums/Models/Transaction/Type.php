<?php

declare(strict_types=1);

namespace App\Enums\Models\Transaction;

enum Type: string
{
    case Incomes   = 'incomes';
    case Expenses  = 'expenses';
    case Transfers = 'transfers';

    public function label(): string
    {
        return match ($this) {
            self::Incomes   => 'Income',
            self::Expenses  => 'Expense / Payment',
            self::Transfers => 'Transfer',
        };
    }
}
