<?php

declare(strict_types = 1);

namespace App\Traits\Requests;

use App\Models\User;

trait ModelRequestTrait
{
    protected ?User $model = null;

    public function setModel(?User $model): void
    {
        $this->model = $model;
    }
}
