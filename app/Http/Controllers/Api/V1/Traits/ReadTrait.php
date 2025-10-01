<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\V1\Traits;

use Core\Application\Builder\GraphBuilder;
use Core\Application\Builder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

trait ReadTrait
{
    abstract private function baseQuery(QueryBuilder $queryBuilder): Builder;

    abstract private function getCollection(GraphBuilder $graphBuilder, $queryBuilderResponse): Collection;

    public function index(QueryBuilder $queryBuilder, GraphBuilder $graphBuilder)
    {
        $queryBuilderResponse = $this->baseQuery($queryBuilder)
            ->orderBy(request()->get('order_column', 'id'), request()->get('order_direction'))
            ->simplePaginate();

        $graphBuilderResponse = $this->getCollection($graphBuilder, $queryBuilderResponse);

        return response()->json($graphBuilderResponse);
    }

    public function show(QueryBuilder $queryBuilder, GraphBuilder $graphBuilder)
    {
        $routeParams = request()->route()->parameters();

        $id = array_pop($routeParams);

        $table = ($baseQuery = $this->baseQuery($queryBuilder))->getModel()->getTable();

        $queryBuilderResponse = $baseQuery
            ->where($table . '.id', $id)
            ->sole();

        $graphBuilderResponse = $this->getCollection($graphBuilder, $queryBuilderResponse);

        return response()->json([
            'data' => $graphBuilderResponse,
        ]);
    }
}
