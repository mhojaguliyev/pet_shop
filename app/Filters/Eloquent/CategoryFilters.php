<?php

namespace App\Filters\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

class CategoryFilters extends QueryFilter
{
    public function sortBy($column): Builder
    {
        if (in_array($column, Schema::getColumnListing('categories'))) {
            $direction = isset($this->filters()['desc']) && $this->filters()['desc'] === 'true';
            $this->builder->orderBy($column, $direction ? 'desc' : 'asc');
        }

        return $this->builder;
    }

    public function limit($count = 20): Builder
    {
        $count = intval($count) ?: 20;
        return $this->builder->take($count);
    }

    public function page($number = 1): Builder
    {
        $number = intval($number) ?: 1;
        return $this->builder->forPage($number);
    }
}
