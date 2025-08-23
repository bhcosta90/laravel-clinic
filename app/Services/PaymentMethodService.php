<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\PaymentMethod;

final class PaymentMethodService extends Service
{
    protected function model(): PaymentMethod
    {
        return new PaymentMethod();
    }

    protected function search(): array
    {
        return ['name'];
    }
}
