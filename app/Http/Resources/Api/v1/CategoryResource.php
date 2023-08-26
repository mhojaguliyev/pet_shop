<?php

namespace App\Http\Resources\Api\v1;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Category
 */
class CategoryResource extends JsonResource
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
            'uuid' => $this->uuid,
            'title' => $this->title,
            'slug' => $this->slug,
            'createdAt' => optional($this->created_at)->format($dateFormat),
            'updatedAt' => optional($this->updated_at)->format($dateFormat),
        ];
    }
}
