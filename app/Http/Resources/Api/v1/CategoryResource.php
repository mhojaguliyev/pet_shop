<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'createdAt' => !empty($this->created_at) ? $this->created_at->format($dateFormat) : null,
            'updatedAt' => !empty($this->updated_at) ? $this->updated_at->format($dateFormat) : null,
        ];
    }
}
