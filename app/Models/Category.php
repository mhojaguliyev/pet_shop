<?php

namespace App\Models;

use App\Traits\HasFilters;
use App\Traits\HasUuid;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Guarded(['id'])]
class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory;

    use HasFilters;
    use HasUuid;

    /**
     * @return HasMany<Product, $this>
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'categories_uuid', 'uuid');
    }
}
