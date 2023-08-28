<?php

namespace App\Http\Controllers\Api\v1;

use App\Filters\Eloquent\ProductFilters;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\v1\Product\ProductRequest;
use App\Http\Resources\Api\v1\PaginationResource;
use App\Http\Resources\Api\v1\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends ApiController
{
    public function __construct()
    {
        $this->middleware(
            ['auth:api'],
            ['except' => ['index', 'show']]
        );
    }

    public function index(ProductFilters $filters): JsonResponse
    {
        $data = Product::filter($filters)->paginate();

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
