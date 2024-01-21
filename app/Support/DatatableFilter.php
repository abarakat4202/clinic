<?php

namespace App\Support;

use Closure;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Database\Query\Builder as QueryBuilder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DatatableFilter
{
    protected Builder $builder;

    public function __construct(public Model $model)
    {
        $this->builder = $model->query();
    }

    public static function make(string $class): static
    {
        return new static(new $class);
    }

    public function apply(array $filters, ?Closure $closure = null): LengthAwarePaginator
    {
        $this->search($filters);
        $this->filter($filters);
        $this->order($filters);
        if (is_callable($closure)) {
            $closure($this->builder);
        }
        return $this->paginate($filters);
    }

    protected function getSearchColumns(array &$filters): array
    {
        return array_reduce($filters['columns'], function (array $carry, array $columnData) {
            if ($columnData['searchable'] == 'true') {
                $carry[] = $columnData['data'];
            }
            return $carry;
        }, []);
    }

    protected function search(array &$filters): Builder
    {
        $search = $filters['search']['value'];

        if ($search == null) {
            return $this->builder;
        }

        $searchColumns = $this->getSearchColumns($filters);

        return $this->builder->where(
            fn ($q) => $this->searchRecursive($q, $search, $searchColumns)
        );
    }

    protected function searchRecursive(QueryBuilder $queryBuilder, string $search, array &$columnNames): Builder
    {
        $columnName = current($columnNames);
        // Base Case
        if ($columnName !== false) {
            // Decomposition
            if (!Str::contains($columnName, '.')) {
                $queryBuilder->orWhere($columnName, 'LIKE', "%{$search}%");
            } else {
                // is relation
                $relationName = Str::beforeLast($columnName, '.');
                $columnName = Str::afterLast($columnName, '.');
                $queryBuilder->orWhereHas(
                    $relationName,
                    fn ($q) => $q->where(Str::after($columnName, '.'), 'LIKE', "%{$search}%")
                );
            }
            next($columnNames);
            // Composition
            return $this->searchRecursive($queryBuilder, $search, $columnNames);
        }

        return $queryBuilder;
    }

    protected function filter(array &$filters): Builder
    {
        foreach ($filters['columns'] as $filterColumnData) {
            $filterValue = $filterColumnData['search']['value'];

            if ($filterValue != null && $filterColumnData['searchable'] == 'true') {
                $filterColumnName = $filterColumnData['data'];
                if (!Str::contains($filterColumnName, '.')) {
                    $this->builder->when(
                        Str::contains($filterValue, ','),
                        fn (QueryBuilder $q) => $q->whereIn($filterColumnName, explode(',', $filterValue)),
                        fn (QueryBuilder $q) => $q->where($filterColumnName, $filterValue),
                    );
                } else {
                    // is relation
                    $relationName = Str::beforeLast($filterColumnName, '.');
                    $columnName = Str::afterLast($filterColumnName, '.');
                    $this->builder->whereHas(
                        $relationName,
                        fn ($q) => $q->when(
                            Str::contains($filterValue, ','),
                            fn (QueryBuilder $q) => $q->whereIn($columnName, explode(',', $filterValue)),
                            fn (QueryBuilder $q) => $q->where($columnName, $filterValue),
                        )
                    );
                }
            }
        }

        return $this->builder;
    }

    protected function order(array &$filters): Builder
    {
        foreach ($filters['order'] as $orderColumnData) {
            $orderColumnIndex = $orderColumnData['column'];
            $orderDir = $orderColumnData['dir'];
            $orderColumnName = $filters['columns'][$orderColumnIndex]['data'];
            $this->builder->orderBy($orderColumnName, $orderDir);
        }

        return $this->builder;
    }

    protected function paginate(array &$filters)
    {
        $perPage = $filters['length'];
        $page = $filters['start'] ? ($filters['start'] / $perPage) + 1 : 1;
        return $this->builder->paginate($perPage, ['*'], 'page', $page);
    }
}
