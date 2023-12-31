<?php

namespace App\Http\Requests\Api\v1\Product;

use Illuminate\Foundation\Http\FormRequest;
use PHPStan\Type\Type;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'categoriesUuid' => 'required|exists:categories,uuid',
            'title' => 'required|min:2',
            'price' => 'required|numeric|gt:0',
            'description' => 'required|min:3',
            'metadata' => 'nullable|array',
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
