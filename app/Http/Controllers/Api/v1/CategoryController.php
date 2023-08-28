<?php

namespace App\Http\Controllers\Api\v1;

use App\Filters\Eloquent\CategoryFilters;
use App\Http\Controllers\ApiController;
use App\Http\Resources\Api\v1\CategoryResource;
use App\Http\Resources\Api\v1\PaginationResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends ApiController
{
    public function index(CategoryFilters $filters): JsonResponse
    {
        $data = Category::filter($filters)->paginate();

        // response
        return $this->sendResponse(data: [
            'data' => CategoryResource::collection($data),
            'pagination' => new PaginationResource($data),
        ]);
    }
}
