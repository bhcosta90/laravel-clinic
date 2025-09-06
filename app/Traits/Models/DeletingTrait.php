<?php

declare(strict_types = 1);

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * DeletingTrait.
 *
 * When attached to a model, this trait allows you to mutate specific fields
 * just before a delete operation occurs (soft or hard delete). The model must
 * implement fieldsUpdatedOnDelete(): array returning a list of attribute names
 * that should be updated on delete. Typical usage is to avoid unique key
 * collisions by appending a timestamp suffix to fields like SKU, code, email, etc.
 *
 * Example in your model:
 *  use DeletingTrait;
 *  protected function fieldsUpdatedOnDelete(): array
 *  {
 *      return ['sku_code', 'email'];
 *  }
 */
trait DeletingTrait
{
    /**
     * Return a list of field names that will be updated when the model is being deleted.
     *
     * @return array<int, string>
     */
    abstract protected function fieldsUpdatedOnDelete(): array;

    protected static function bootDeletingTrait(): void
    {
        static::deleting(function ($model): void {
            $fields = $model->fieldsUpdatedOnDelete();

            if (empty($fields)) {
                return; // Nothing configured, skip
            }

            // Do not re-fire events nor touch timestamps for this internal update
            $originalTimestamps = $model->timestamps;
            $model->timestamps  = false;

            $suffix = '-DT' . now()->format('YmdHis');

            foreach ($fields as $field) {
                // Skip if attribute not fillable/present
                if (!array_key_exists($field, $model->getAttributes())) {
                    // If it's a casted/accessible attribute, try getAttribute anyway
                    $current = $model->getAttribute($field);

                    if (null === $current) {
                        continue;
                    }
                } else {
                    $current = $model->getAttribute($field);
                }

                if (null === $current || '' === $current) {
                    // Nothing to change
                    continue;
                }

                // Ensure we work with stringish values
                $currentString = (string) $current;

                // Avoid duplicating suffix on repeated attempts; if already ends with -YYYYmmddHHIISS, append only once
                if (1 === preg_match('/-\d{14}$/', $currentString)) {
                    // Already suffixed; keep as-is
                    continue;
                }

                $model->setAttribute($field, Str::limit($currentString . $suffix, 191, ''));
            }

            // Save quietly without firing events
            Model::withoutEvents(function () use ($model, $originalTimestamps): void {
                // Only persist if dirty
                if ($model->isDirty()) {
                    $model->saveQuietly();
                }
                // restore timestamps behavior
                $model->timestamps = $originalTimestamps;
            });
        });
    }
}
