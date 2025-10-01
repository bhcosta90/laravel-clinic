<?php

declare(strict_types = 1);

namespace Core\Application\Repository;

use App\Models\Specialty;
use Core\Domain\Entities\Requests\Specialty\SpecialtyCreateRequest;
use Core\Domain\Entities\SpecialtyEntity;
use Core\Domain\Repository\SpecialtyRepositoryInterface;
use Core\Shared\Domain\BaseDomain;
use Illuminate\Database\Eloquent\Model;

final class SpecialtyRepository implements SpecialtyRepositoryInterface
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
        $model = new Specialty();
        $model->fill([
            'uuid' => $domain->id,
            'code' => $domain->code,
            'name' => $domain->name,
        ]);
        $model->save();

        return $this->convertModelToDomain($model);
    }

    public function update(BaseDomain $domain): BaseDomain
    {
        $model = $this->getModelById($domain->id);
        $model->fill([
            'name' => $domain->name,
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
        return new Specialty();
    }

    private function getModelById(int | string $id): ?Model
    {
        return $this->model()->query()->where('uuid', $id)->first();
    }

    private function convertModelToDomain(?object $model): ?SpecialtyEntity
    {
        return when($model, fn () => new SpecialtyEntity(new SpecialtyCreateRequest(
            name: $model->name,
            code: $model->code,
        ), $model->uuid));
    }
}
