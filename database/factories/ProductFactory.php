<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    #[\Override]
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'categories_uuid' => Category::factory()->create()->uuid,
            'title' => fake()->sentence(3),
            'price' => fake()->numberBetween(1),
            'description' => fake()->paragraph(),
        ];
    }
}
