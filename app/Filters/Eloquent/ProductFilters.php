<?php

namespace App\Filters\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

class ProductFilters extends QueryFilter
{
    public function title($search): Builder
    {
        return $this->builder->where('title', 'like', "%{$search}%");
    }

    public function sortBy($column): Builder
    {
        if (in_array($column, Schema::getColumnListing('products'))) {
            $direction = isset($this->filters()['desc']) && $this->filters()['desc'] === 'true';
            $this->builder->orderBy($column, $direction ? 'desc' : 'asc');
        }

        return $this->builder;
    }

    public function category($search): Builder
    {
        return $this->builder->whereHas(
            'categories',
            fn (Builder $query) => $query->where('title', 'like', "%{$search}%")
        );
    }

    public function price($value): Builder
    {
        $value = (float) $value;
        if ($value) {
            $this->builder->where('price', '<', $value);
        }

        return $this->builder;
    }
}
