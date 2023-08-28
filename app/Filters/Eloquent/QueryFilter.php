<?php

namespace App\Filters\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use PHPStan\Type\Type;

abstract class QueryFilter
{
    protected Request $request;

    /**
     * @var Builder<Model>
     */
    protected Builder $builder;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return array<string, mixed>
     */
    public function filters(): array
    {
        return $this->request->all();
    }

    /**
     * @param Builder<Model> $builder
     * @return Builder<Model>
     */
    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->filters() as $name => $value) {
            $callback = [$this, $name];
            if (method_exists($this, $name) && is_callable($callback)) {
                call_user_func_array($callback, array_filter([$value]));
            }
        }

        return $this->builder;
    }

    public function limit(): int
    {
        return $this->filters()['limit'] ?? 20;
    }
}
