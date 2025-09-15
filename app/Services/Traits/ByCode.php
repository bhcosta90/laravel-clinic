<?php

declare(strict_types = 1);

namespace App\Services\Traits;

use App\Models\Eloquent\Model;

trait ByCode
{
    abstract protected function model();

    public function showByCode(string $code): Model
    {
        $model = $this->model();

        return $model::findOrFail($model::decodeHashCode($code));
    }
}
