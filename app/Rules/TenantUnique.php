<?php

declare(strict_types = 1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

/**
 * Generic tenant-scoped unique rule.
 *
 * Usage:
 *   new TenantUnique(Location::class, 'code')
 */
final readonly class TenantUnique implements DataAwareRule, ValidationRule
{
    public function __construct(
        private string $modelClass,
        private ?string $column,
        private string | int | null $ignoreId = null,
        private string $tenantColumn = 'tenant_id'
    ) {
        if (!is_subclass_of($modelClass, Model::class)) {
            throw new InvalidArgumentException('TenantUnique: $modelClass must be an Eloquent Model class name.');
        }
    }

    public function setData(array $data): static
    {
        return $this;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (null === $value || '' === $value) {
            return;
        }

        $tenantId = tenant()->id ?? null;

        if (null === $tenantId) {
            $fail(__('validation.unique'));

            return;
        }

        /** @var Model $model */
        $model = new $this->modelClass();
        $table = $model->getTable();

        $exists = DB::table($table)
            ->where($this->column, $value)
            ->where($this->tenantColumn, $tenantId)
            ->when($this->ignoreId, fn ($query) => $query->where($model->getKeyName(), '!=', $this->ignoreId))
            ->when(in_array(SoftDeletes::class, class_uses_recursive($model)), fn ($query) => $query->whereNull('deleted_at'))
            ->exists();

        if ($exists) {
            $fail(__('validation.unique'));
        }
    }
}
