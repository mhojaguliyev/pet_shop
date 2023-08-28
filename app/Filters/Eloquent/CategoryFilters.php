<?php

namespace App\Filters\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class CategoryFilters extends QueryFilter
{
    /**
     * @param string $column
     * @return Builder<Model>
     */
    public function sortBy(string $column): Builder
    {
        if (in_array($column, Schema::getColumnListing('categories'))) {
            $direction = isset($this->filters()['desc']) && $this->filters()['desc'] === 'true';
            $this->builder->orderBy($column, $direction ? 'desc' : 'asc');
        }

        return $this->builder;
    }
}
