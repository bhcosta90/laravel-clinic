<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Customer;

final class CustomerService extends Service
{
    protected function model(): Customer
    {
        return new Customer();
    }

    protected function search(): array
    {
        return ['name'];
    }
}
