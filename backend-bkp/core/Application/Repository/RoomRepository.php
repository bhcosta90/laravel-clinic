<?php

declare(strict_types = 1);

namespace Core\Application\Repository;

use App\Models\Room;
use Core\Domain\Entities\Requests\Room\RoomCreateRequest;
use Core\Domain\Entities\RoomEntity;
use Core\Domain\Repository\RoomRepositoryInterface;
use Core\Shared\Domain\BaseDomain;
use Illuminate\Database\Eloquent\Model;

final readonly class RoomRepository implements RoomRepositoryInterface
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
        $model = new Room();
        $model->fill([
            'uuid'      => $domain->id,
            'code'      => $domain->code,
            'name'      => $domain->name,
            'is_active' => $domain->isActive,
        ]);
        $model->save();

        return $this->convertModelToDomain($model);
    }

    public function update(BaseDomain $domain): BaseDomain
    {
        $model = $this->getModelById($domain->id);
        $model->fill([
            'name'      => $domain->name,
            'is_active' => $domain->isActive,
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
        return new Room();
    }

    private function getModelById(int | string $id): ?Model
    {
        return $this->model()->query()->where('uuid', $id)->first();
    }

    private function convertModelToDomain(?object $model): ?RoomEntity
    {
        return when($model, fn () => new RoomEntity(new RoomCreateRequest(
            name: $model->name,
            code: $model->code,
            isActive: $model->is_active,
        ), $model->uuid));
    }
}
