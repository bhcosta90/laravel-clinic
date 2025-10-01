<?php

namespace Core\Application\Repository;

use App\Models\Patient;
use Core\Domain\Entities\PatientEntity;
use Core\Domain\Entities\Requests\Patient\PatientCreateRequest;
use Core\Domain\Repository\PatientRepositoryInterface;
use Core\Shared\Domain\BaseDomain;
use Illuminate\Database\Eloquent\Model;

class PatientRepository implements PatientRepositoryInterface
{
    public function find(int|string $id): ?BaseDomain
    {
        return $this->convertModelToDomain($this->getModelById($id));
    }

    public function delete(BaseDomain $domain): bool
    {
        return $this->getModelById($domain->id)->delete();
    }

    public function store(BaseDomain $domain): BaseDomain
    {
        $model = new Patient;
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
            $i++;

            if ($i % $min === 0) {
                $min++;
            }
        } while ($this->model()->query()->where('code', $code)->exists());

        return (string) $code;
    }

    protected function model(): Model
    {
        return new Patient;
    }

    protected function getModelById(int|string $id): ?Model
    {
        return $this->model()->query()->where('uuid', $id)->first();
    }

    protected function convertModelToDomain(?object $model): ?PatientEntity
    {
        return when($model, fn () => new PatientEntity(new PatientCreateRequest(
            name: $model->name,
            code: $model->code,
        ), $model->uuid));
    }
}
