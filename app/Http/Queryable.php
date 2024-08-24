<?php

namespace App\Http;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

trait Queryable
{
    /**
     * Apply filtering to the query based on a filter array.
     *
     * @param Builder $query
     * @param array|null $filter
     * @return Builder
     */
    public function scopeFilter(Builder $query, ?array $filter): Builder
    {
        if (!empty($filter['field']) && isset($filter['value']) && Schema::hasColumn($this->getTable(), $filter['field'])) {
            $field = $filter['field'];
            $value = $filter['value'];
            $type = $filter['type'] ?? 'contains';

            switch ($type) {
                case 'contains':
                    $query->where($field, 'like', "%{$value}%");
                    break;
                case 'equal':
                    $query->where($field, '=', $value);
                    break;
                case 'starts_with':
                    $query->where($field, 'like', "{$value}%");
                    break;
                case 'ends_with':
                    $query->where($field, 'like', "%{$value}");
                    break;
                case 'is_not_empty':
                    $query->whereNotNull($field)->where($field, '!=', '');
                    break;
                case 'is_empty':
                    $query->where(function ($q) use ($field) {
                        $q->whereNull($field)->orWhere($field, '=', '');
                    });
                    break;
                case 'is_any_of':
                    $query->whereIn($field, is_array($value) ? $value : explode(',', $value));
                    break;
            }
        }

        return $query;
    }

    /**
     * Apply sorting to the query.
     *
     * @param Builder $query
     * @param string|null $sortBy Comma-separated fields to sort by.
     * @param string|null $sortOrder Comma-separated orders, corresponding to each field.
     * @return Builder
     */
    public function scopeSort(Builder $query, ?string $sortBy, ?string $sortOrder = 'asc'): Builder
    {
        if (!empty($sortBy)) {
            $sortFields = explode(',', $sortBy);
            $sortOrders = explode(',', $sortOrder);

            foreach ($sortFields as $index => $field) {
                $order = $sortOrders[$index] ?? 'asc';

                // Apply sorting if the field is valid.
                if (Schema::hasColumn($this->getTable(), $field)) {
                    $query->orderBy($field, $order);
                }
            }
        }

        return $query;
    }

    /**
     * Apply custom pagination settings to the query.
     *
     * @param Builder $query
     * @param int|null $size Number of items per page.
     * @param int $page Current page number.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function scopePaginated(Builder $query, ?int $size = null, ?int $page = null)
    {
        // If no custom size is provided, use a default size of 10.
        $perPage = $size ?: 10;
        $page = $page ?: 1;

        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}
