<?php

namespace App\Models;

use App\Traits\HasFilters;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[\Illuminate\Database\Eloquent\Attributes\Guarded(['id'])]
class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    use HasUuid;
    use SoftDeletes;
    use HasFilters;

    /**
     * @var list<string>
     */
    protected $with = ['category'];

    /**
     * @return BelongsTo<Category, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'categories_uuid', 'uuid');
    }

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
        ];
    }
}
