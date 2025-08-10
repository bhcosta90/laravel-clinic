<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\Models\Permission\Can;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class TransactionPolicy
{
    use HandlesAuthorization;

    public function viewIncomesAny(User $user): bool
    {
        return $user->hasPermissionTo(Can::TransactionIncomeView);
    }

    public function viewExpensesAny(User $user): bool
    {
        return $user->hasPermissionTo(Can::TransactionExpenseView);
    }

    public function createIncomes(User $user): bool
    {
        return $user->hasPermissionTo(Can::TransactionIncomeEdit);
    }

    public function createExpenses(User $user): bool
    {
        return $user->hasPermissionTo(Can::TransactionExpenseEdit);
    }

    public function updateIncomes(User $user): bool
    {
        return $user->hasPermissionTo(Can::TransactionIncomeEdit);
    }

    public function updateExpenses(User $user): bool
    {
        return $user->hasPermissionTo(Can::TransactionExpenseEdit);
    }

    public function deleteIncomes(User $user): bool
    {
        return $user->hasPermissionTo(Can::TransactionIncomeEdit);
    }

    public function deleteExpenses(User $user): bool
    {
        return $user->hasPermissionTo(Can::TransactionExpenseEdit);
    }

    public function sendReceiptAgreement(User $user): bool
    {
        return $user->hasPermissionTo(Can::TransactionIncomeEdit);
    }
}
