<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * Test if products table has some columns
     *
     * @return void
     */
    public function test_products_table_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('products', [
                'id', 'categories_uuid', 'uuid', 'title', 'price',
            ]),
            1
        );
    }

    /**
     * Test if products has category relation
     *
     * @return void
     */
    public function test_product_belongs_to_a_category(): void
    {
        $product = Product::first();

        $this->assertEquals(1, $product->category()->count());
        $this->assertInstanceOf(Category::class, $product->category);
    }
}
