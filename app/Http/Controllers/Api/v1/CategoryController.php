<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Api\v1\CategoryResource;
use App\Http\Resources\Api\v1\PaginationResource;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class CategoryController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        // product table columns
        $tableColumns = Schema::getColumnListing((new Category())->getTable());

        // fetch data
        $data = Category::query()
            ->when(
                $request->filled('sortBy') && in_array($request->input('sortBy'), $tableColumns),
                function (Builder $query) use ($request) {
                    $query->orderBy(
                        $request->input('sortBy'),
                        $request->input('desc') ? 'desc' : 'asc'
                    );
                }
            )
            ->paginate(
                perPage: $request->integer('limit') ? $request->integer('limit') : 20,
                page: $request->integer('page') ? $request->integer('page') : 1
            );

        // appent input parameters
        $data->appends($request->all());

        // response
        return $this->sendResponse(data: [
            'data' => CategoryResource::collection($data),
            'pagination' => new PaginationResource($data),
        ]);
    }

}