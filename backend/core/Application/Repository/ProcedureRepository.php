<?php

declare(strict_types = 1);

namespace Core\Application\Repository;

use App\Models\Procedure;
use Core\Domain\Entities\ProcedureEntity;
use Core\Domain\Entities\Requests\Procedure\ProcedureCreateRequest;
use Core\Domain\Repository\ProcedureRepositoryInterface;
use Core\Shared\Domain\BaseDomain;
use Illuminate\Database\Eloquent\Model;

final readonly class ProcedureRepository implements ProcedureRepositoryInterface
{
    public function find(int | string $id): ?BaseDomain
    {
        return $this->convertModelToDomain($this->getModelById($id));
    }

    public function delete(BaseDomain $domain): bool
    {
        return $this->getModelById($domain->id)->delete();
    }

    public function store(BaseDomain $domain): BaseDomain
    {
        $model = new Procedure();
        $model->fill([
            'uuid'                 => $domain->id,
            'code'                 => $domain->code,
            'name'                 => $domain->name,
            'min_duration_minutes' => $domain->minDurationMinutes,
            'max_duration_minutes' => $domain->maxDurationMinutes,
        ]);
        $model->save();

        return $this->convertModelToDomain($model);
    }

    public function update(BaseDomain $domain): BaseDomain
    {
        $model = $this->getModelById($domain->id);
        $model->fill([
            'name'                 => $domain->name,
            'min_duration_minutes' => $domain->minDurationMinutes,
            'max_duration_minutes' => $domain->maxDurationMinutes,
        ]);
        $model->save();

        return $this->convertModelToDomain($model);
    }

    public function generateCode(int $min): string
    {
        $i = 0;

        do {
            $code = mb_strtoupper(str()->random($min));
            ++$i;

            if (0 === $i % $min) {
                ++$min;
            }
        } while ($this->model()->query()->where('code', $code)->exists());

        return (string) $code;
    }

    private function model(): Model
    {
        return new Procedure();
    }

    private function getModelById(int | string $id): ?Model
    {
        return $this->model()->query()->where('uuid', $id)->first();
    }

    private function convertModelToDomain(?object $model): ?ProcedureEntity
    {
        return when($model, fn () => new ProcedureEntity(new ProcedureCreateRequest(
            name: $model->name,
            code: $model->code,
            minDurationMinutes: $model->min_duration_minutes,
            maxDurationMinutes: $model->max_duration_minutes,
        ), $model->uuid));
    }
}
