<?php

namespace App\Traits;

use App\Filters\Eloquent\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

trait HasFilters
{
    public function scopeFilter(Builder $query, QueryFilter $filters): Builder
    {
        return $filters->apply($query);
    }
}
