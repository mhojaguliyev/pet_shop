<?php

namespace App\Filters\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class ProductFilters extends QueryFilter
{
    /**
     * @param string $search
     * @return Builder<Model>
     */
    public function title(string $search): Builder
    {
        return $this->builder->where('title', 'like', "%{$search}%");
    }

    /**
     * @param string $column
     * @return Builder<Model>
     */
    public function sortBy(string $column): Builder
    {
        if (in_array($column, Schema::getColumnListing('products'))) {
            $direction = isset($this->filters()['desc']) && $this->filters()['desc'] === 'true';
            $this->builder->orderBy($column, $direction ? 'desc' : 'asc');
        }

        return $this->builder;
    }

    /**
     * @param string $search
     * @return Builder<Model>
     */
    public function category(string $search): Builder
    {
        return $this->builder->whereHas(
            'categories',
            fn (Builder $query) => $query->where('title', 'like', "%{$search}%")
        );
    }

    /**
     * @param float $value
     * @return Builder<Model>
     */
    public function price(float $value): Builder
    {
        if ($value) {
            $this->builder->where('price', '<', $value);
        }

        return $this->builder;
    }
}
