<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @mixin LengthAwarePaginator<Model>
 */
class PaginationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'page' => $this->currentPage(),
            'total' => $this->total(),
            'lastPage' => $this->lastPage(),
            'perPage' => $this->perPage(),
            'prevPageUrl' => $this->previousPageUrl(),
            'nextPageUrl' => $this->nextPageUrl(),
        ];
    }
}
