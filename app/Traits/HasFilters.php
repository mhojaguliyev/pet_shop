<?php

namespace App\Traits;

use App\Filters\Eloquent\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait HasFilters
{
    /**
     * @param  Builder<Model>  $query
     * @return Builder<Model>
     */
    protected function scopeFilter(Builder $query, QueryFilter $filters): Builder
    {
        return $filters->apply($query);
    }
}
