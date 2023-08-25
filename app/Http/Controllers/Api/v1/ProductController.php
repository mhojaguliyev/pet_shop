<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\v1\Product\ProductRequest;
use App\Http\Resources\Api\v1\PaginationResource;
use App\Http\Resources\Api\v1\ProductResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ProductController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        // product table columns
        $productTableColumns = Schema::getColumnListing((new Product())->getTable());

        $data = Product::with(['category'])
            ->when(
                $request->filled('title'),
                fn(Builder $query) => $query->where('title', 'like', '%' . $request->input('title') . '%')
            )
            ->when(
                $request->filled('sortBy') && in_array($request->input('sortBy'), $productTableColumns),
                fn(Builder $query) => $query->orderBy(
                    $request->input('sortBy'),
                    $request->input('desc') ? 'desc' : 'asc'
                )
            )
            ->when(
                $request->filled('category'),
                fn(Builder $query) => $query->whereHas(
                    'categories',
                    fn(Builder $query) => $query->where('title', 'like', '%' . $request->input('category') . '%')
                )
            )
            // assume max price
            ->when(
                $request->integer('price'),
                fn(Builder $query) => $query->where('price', '<', $request->integer('price'))
            )
            ->paginate(
                perPage: $request->integer('limit') ? $request->integer('limit') : 20,
                page: $request->integer('page') ? $request->integer('page') : 1
            );

        $data->appends($request->all());
        return $this->sendResponse(data: [
            'data' => ProductResource::collection($data),
            'pagination' => new PaginationResource($data),
        ]);
    }

    public function create(ProductRequest $request): JsonResponse
    {
        // create product
        $productData = $this->_transformValidatedProductData($request);
        $product = Product::create($productData);

        // load relation
        $product->load(['category']);
        return $this->sendResponse('Created', data: new ProductResource($product), code: 201);
    }

    public function show(Product $product): JsonResponse
    {
        return $this->sendResponse(data: new ProductResource($product));
    }

    public function update(Product $product, ProductRequest $request): JsonResponse
    {
        // update product
        $productData = $this->_transformValidatedProductData($request);
        $product->update($productData);

        return $this->sendResponse('Updated', data: new ProductResource($product));
    }

    public function destroy(Product $product): JsonResponse
    {
        // soft delete product
        $product->delete();

        return $this->sendResponse('Deleted.');
    }

    private function _transformValidatedProductData(FormRequest $request): array
    {
        $productData = $request->validated();
        return [
            'categories_uuid' => $productData['categoriesUuid'],
            'title' => $productData['title'],
            'price' => $productData['price'],
            'description' => $productData['description'],
            'metadata' => $productData['metadata'] ?? [],
        ];
    }
}
