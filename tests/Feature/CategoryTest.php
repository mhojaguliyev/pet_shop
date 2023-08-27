<?php

namespace Tests\Feature;

use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * Test categories route returns ok
     *
     * @return void
     */
    public function test_categories_route_returns_ok(): void
    {
        $response = $this->get('/api/v1/categories');
        $response->assertStatus(200);
    }

    /**
     * Test categories response
     *
     * @return void
     */
    public function test_categories_response(): void
    {
        $response = $this->get('/api/v1/categories');
        $response->assertStatus(200);
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
