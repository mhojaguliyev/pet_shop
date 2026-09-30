<?php

namespace App\Http\Requests\Api\v1\Product;

use Illuminate\Foundation\Http\FormRequest;
use PHPStan\Type\Type;

class ProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'categoriesUuid' => ['required', 'exists:categories,uuid'],
            'title' => ['required', 'min:2'],
            'price' => ['required', 'numeric', 'gt:0'],
            'description' => ['required', 'min:3'],
            'metadata' => ['nullable', 'array'],
        ];
    }

    /**
     * Prepare data after validation successful
     *
     * @return array<string, Type>
     */
    public function prepareValidated(): array
    {
        $productData = $this->validated();

        return [
            'categories_uuid' => $productData['categoriesUuid'],
            'title' => $productData['title'],
            'price' => $productData['price'],
            'description' => $productData['description'],
            'metadata' => $productData['metadata'] ?? [],
        ];
    }
}
