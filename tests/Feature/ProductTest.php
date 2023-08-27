<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * Test if product route returns ok
     *
     * @return void
     */
    public function test_products_route_returns_ok()
    {
        $response = $this->get('/api/v1/products');
        $response->assertStatus(200);
    }

    /**
     * Test if user can read single product
     *
     * @return void
     */
    public function test_user_can_read_single_product()
    {
        $product = Product::factory()->create();
        $response = $this->get('/api/v1/product/' . $product->uuid);
        $response->assertSee($product->title)
            ->assertSee($product->description);
    }

    /**
     * Test if auth user can create new product
     *
     * @return void
     */
    public function test_authenticated_users_can_create_a_new_product()
    {
        $this->actingAs(User::factory()->create());

        // prepare product data
        $product = Product::factory()->create();
        $productData = $product->toArray();
        $productData['categoriesUuid'] = $product->category->uuid;

        // make request
        $response = $this->post('/api/v1/product/create', $productData);
        $response->assertStatus(201);
    }

    /**
     * Test if unauthenticated user can not create new product
     *
     * @return void
     */
    public function test_unauthenticated_users_cannot_create_a_new_product()
    {
        // prepare product data
        $product = Product::factory()->create();
        $productData = $product->toArray();
        $productData['categoriesUuid'] = $product->category->uuid;

        // make request
        $response = $this->post('/api/v1/product/create', $productData, [
            'Accept' => 'application/json'
        ]);
        $response->assertStatus(401);
    }

    /**
     * Test if auth user can update product
     *
     * @return void
     */
    public function test_authenticated_user_can_update_the_product()
    {
        $this->actingAs(User::factory()->create());

        $product = DB::table('products')->first();
        $product->title = "Updated Title";
        $productData = json_decode(json_encode($product), true);
        $productData['categoriesUuid'] = $productData['categories_uuid'];

        $this->put('/api/v1/product/' . $product->uuid, $productData);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'uuid' => $product->uuid,
            'title' => 'Updated Title',
        ]);
    }

    /**
     * Test if auth user can delete product
     *
     * @return void
     */
    public function test_authenticated_user_can_delete_the_product()
    {
        $this->actingAs(User::factory()->create());

        $product = Product::factory()->createOne();
        $this->delete('/api/v1/product/' . $product->uuid);

        //The product should be deleted from the database.
        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }
}
