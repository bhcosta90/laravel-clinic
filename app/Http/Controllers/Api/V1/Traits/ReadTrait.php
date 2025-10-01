<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\V1\Traits;

use Core\Application\Builder\GraphBuilder;
use Core\Application\Builder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait ReadTrait
{
    abstract protected function model(): Model;

    public function index(QueryBuilder $queryBuilder, GraphBuilder $graphBuilder)
    {
        $queryBuilderResponse = $this->baseQuery($queryBuilder)
            ->orderBy(request()->get('order_column', $this->getKeyName()), request()->get('order_direction', 'asc'))
            ->simplePaginate();

        $graphBuilderResponse = $this->getCollection($graphBuilder, $queryBuilderResponse);

        if (app()->isLocal() && $this->allowedIncludes ?? null) {
            $graphBuilderResponse->prepend($this->allowedIncludes, 'allowed_fields');
        }

        return response()->json($graphBuilderResponse);
    }

    public function show(QueryBuilder $queryBuilder, GraphBuilder $graphBuilder)
    {
        $routeParams = request()->route()->parameters();

        $id = array_pop($routeParams);

        $table = ($baseQuery = $this->baseQuery($queryBuilder))->getModel()->getTable();

        $queryBuilderResponse = $baseQuery
            ->where($table . '.' . $this->getKeyName(), $id)
            ->sole();

        $graphBuilderResponse = $this->getCollection($graphBuilder, $queryBuilderResponse);

        $response = collect([
            'data' => $graphBuilderResponse,
        ]);

        if (app()->isLocal() && $this->allowedIncludes ?? null) {
            $response->prepend($this->allowedIncludes, 'allowed_fields');
        }

        return response()->json($response);
    }

    protected function defaultQuery(Builder $queryBuilder)
    {
        return $queryBuilder;
    }

    protected function getKeyName()
    {
        return $this->model()->getKeyName();
    }

    private function getCollection(GraphBuilder $graphBuilder, $queryBuilderResponse): Collection
    {
        return $graphBuilder->execute(
            $queryBuilderResponse,
            fields: request()->get('fields', [$this->getKeyName()]),
            onlyFields: $this->allowedIncludes ?? [],
        );
    }

    private function baseQuery(QueryBuilder $queryBuilder): Builder
    {
        return $this->defaultQuery($queryBuilder->execute($this->model()));
    }
}
