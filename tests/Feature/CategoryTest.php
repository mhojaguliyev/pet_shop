<?php

namespace Tests\Feature;

use App\Models\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * Test categories route returns ok
     */
    public function test_categories_route_returns_ok(): void
    {
        Category::factory()->createOne();

        $response = $this->get('/api/v1/categories');
        $response->assertOk();
    }

    /**
     * Test categories response
     */
    public function test_categories_response(): void
    {
        Category::factory()->createOne();

        $response = $this->get('/api/v1/categories');
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'data' => [
                'data' => [
                    [
                        'id',
                        'uuid',
                    ],
                ],
                'pagination' => [
                    'total',
                    'page',
                    'perPage',
                ],
            ],
        ]);
    }
}
