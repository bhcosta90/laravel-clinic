<?php

declare(strict_types = 1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

/**
 * Generic tenant-scoped exists rule.
 *
 * Usage:
 *   new TenantExists(Sector::class, 'id')               // defaults tenant column to 'tenant_id'
 *   new TenantExists(User::class, 'email', 'tenant_id') // custom column and tenant column if needed
 */
final class TenantExists implements DataAwareRule, ValidationRule
{
    /**
     * @param class-string<Model> $modelClass   Eloquent model class
     * @param string              $tenantColumn Tenant discriminator column (default 'tenant_id')
     */
    public function __construct(private readonly string $modelClass, private ?string $column = null, private readonly string $tenantColumn = 'tenant_id')
    {
        if (!is_subclass_of($modelClass, Model::class)) {
            throw new InvalidArgumentException('TenantExists: $modelClass must be an Eloquent Model class name.');
        }

        if (blank($this->column)) {
            $this->column = (new $modelClass())->getKeyName();
        }
    }

    public function setData(array $data): self
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
            // If there's no tenant context, we consider it a failure to avoid leaking cross-tenant data
            $fail(__('validation.exists'));

            return;
        }

        /** @var Model $model */
        $model = new $this->modelClass();
        $table = $model->getTable();

        $exists = DB::table($table)
            ->where($this->column, $value)
            ->where($this->tenantColumn, $tenantId)
            ->exists();

        if (!$exists) {
            // Reuse the default exists message for localization
            $fail(__('validation.exists'));
        }
    }
}
