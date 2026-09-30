<?php

namespace App\Http\Controllers\Api\v1;

use App\Filters\Eloquent\ProductFilters;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\v1\Product\ProductRequest;
use App\Http\Resources\Api\v1\PaginationResource;
use App\Http\Resources\Api\v1\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductController extends ApiController implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     *
     * @return array<int, Middleware>
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show']),
        ];
    }

    public function index(ProductFilters $filters): JsonResponse
    {
        $data = Product::query()->filter($filters)->paginate($filters->limit());

        // response
        return $this->sendResponse(data: [
            'data' => ProductResource::collection($data),
            'pagination' => new PaginationResource($data),
        ]);
    }

    public function create(ProductRequest $request): JsonResponse
    {
        // create product
        $productData = $request->prepareValidated();
        $product = Product::query()->create($productData);

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
        $productData = $request->prepareValidated();
        $product->update($productData);

        return $this->sendResponse('Updated', data: new ProductResource($product));
    }

    public function destroy(Product $product): JsonResponse
    {
        // soft delete product
        $product->delete();

        return $this->sendResponse('Deleted.');
    }
}
