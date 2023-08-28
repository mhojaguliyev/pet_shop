<?php

namespace App\Models;

use App\Traits\HasFilters;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use HasUuid;
    use SoftDeletes;
    use HasFilters;

    protected $guarded = ['id'];

    /**
     * @var array<string>
     */
    protected $with = ['category'];

    protected $casts = [
        'metadata' => 'array',
    ];

    /**
     * @return BelongsTo<Category, Product>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'categories_uuid', 'uuid');
    }
}
