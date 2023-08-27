<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * Test if category has products relation
     *
     * @return void
     */
    public function test_category_has_non_empty_products_relation(): void
    {
        $category = Category::factory()
            ->has(Product::factory())
            ->create();

        $category->load('products');
        $this->assertTrue($category->products->isNotEmpty());
    }
}
