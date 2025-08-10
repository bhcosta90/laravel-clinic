<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Models\Transaction\Type;
use App\Models\Agreement;
use App\Models\Customer;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

final class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $paymentMethods = PaymentMethod::pluck('id')->toArray();
        $customers      = Customer::pluck('id')->toArray();
        $users          = User::whereIsEmployee(true)->pluck('id')->toArray();
        $agreements     = Agreement::pluck('id')->toArray();

        Transaction::factory(25)->make()->each(function ($item) use ($paymentMethods, $customers, $agreements): void {
            $item->type              = Type::Incomes;
            $item->payment_method_id = collect($paymentMethods)->random();
            $item->customer_id       = collect($customers)->random();
            $item->agreement_id      = collect($agreements)->random();
            $item->save();
        });

        Transaction::factory(25)->make()->each(function ($item) use ($paymentMethods, $users): void {
            $item->type              = Type::Expenses;
            $item->payment_method_id = collect($paymentMethods)->random();
            $item->user_id           = collect($users)->random();
            $item->save();
        });
    }
}
