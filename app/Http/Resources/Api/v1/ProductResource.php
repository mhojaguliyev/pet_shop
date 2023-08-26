<?php

namespace App\Http\Resources\Api\v1;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Product
 */
class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $dateFormat = config('app.date_format');
        return [
            'id' => $this->id,
            'category' => new CategoryResource($this->category),
            'title' => $this->title,
            'uuid' => $this->uuid,
            'price' => (float) $this->price,
            'description' => $this->description,
            'metadata' => $this->metadata ?? [],
            'createdAt' => optional($this->created_at)->format($dateFormat),
            'updatedAt' => optional($this->updated_at)->format($dateFormat),
        ];
    }
}
