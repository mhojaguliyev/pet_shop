<?php

namespace App\Models;

use App\Traits\HasFilters;
use App\Traits\HasUuid;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Guarded(['id'])]
class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    use HasFilters;
    use HasUuid;
    use SoftDeletes;

    /**
     * @var list<string>
     */
    #[\Override]
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
