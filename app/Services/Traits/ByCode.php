<?php

declare(strict_types = 1);

namespace App\Services\Traits;

use App\Models\Eloquent\Model;
use App\Models\Role;
use App\Models\User;

trait ByCode
{
    abstract protected function model();

    public function showByCode(string $code): User | Role
    {
        $model = $this->model();

        return $model::findOrFail($model::decodeHashCode($code));
    }
}
