<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUuid
{
    /**
     * Generate uuid for model Eloquent model's uuid column
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            $property = property_exists($model, 'uuidKey') ? $model->uuidKey : 'uuid';
            if (empty($model->{$property})) {
                $model->{$property} = Str::uuid()->toString();
            }
        });
    }
}
