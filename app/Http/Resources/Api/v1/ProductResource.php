<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'metadata' => $this->metadata,
            'createdAt' => !empty($this->created_at) ? $this->created_at->format($dateFormat) : null,
            'updatedAt' => !empty($this->updated_at) ? $this->updated_at->format($dateFormat) : null,
        ];
    }
}
