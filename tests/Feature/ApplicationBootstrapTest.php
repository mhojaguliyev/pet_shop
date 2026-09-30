<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ApplicationBootstrapTest extends TestCase
{
    /**
     * Test api routes are rate limited by the "api" limiter.
     */
    public function test_api_routes_are_rate_limited(): void
    {
        $this->get('api/v1/categories')
            ->assertOk()
            ->assertHeader('X-RateLimit-Limit', 60)
            ->assertHeader('X-RateLimit-Remaining', 59);
    }

    /**
     * Test missing authentication is rendered as a json response even without json accept header.
     */
    public function test_unauthenticated_request_returns_json_401(): void
    {
        $this->get('api/v1/user')
            ->assertUnauthorized()
            ->assertExactJson(['message' => 'Unauthenticated', 'data' => []]);
    }

    /**
     * Test an invalid bearer token is rendered as a json response.
     */
    public function test_invalid_token_returns_json_401(): void
    {
        $this->withToken('1|invalid-token')->get('api/v1/user')
            ->assertUnauthorized()
            ->assertExactJson(['message' => 'Unauthenticated', 'data' => []]);
    }

    /**
     * Test http exceptions keep their status code in the json response.
     */
    public function test_missing_model_returns_json_404(): void
    {
        $this->get('api/v1/product/non-existent-uuid')
            ->assertNotFound()
            ->assertJsonStructure(['message', 'data']);
    }

    /**
     * Test method not allowed exceptions are rendered as json.
     */
    public function test_wrong_http_method_returns_json_error(): void
    {
        $this->delete('api/v1/categories')->assertMethodNotAllowed()
            ->assertJsonStructure(['message', 'data']);
    }

    /**
     * Test the "user_type" middleware alias rejects users of another type.
     */
    public function test_user_type_middleware_rejects_admin_on_user_route(): void
    {
        $admin = User::factory()->createOne(['is_admin' => true]);
        $token = $admin->createToken('api')->plainTextToken;

        $this->withToken($token)->get('api/v1/user')
            ->assertForbidden()
            ->assertExactJson(['message' => 'Forbidden', 'data' => []]);
    }

    /**
     * Test login updates the last login time and issues an expiring token.
     */
    public function test_login_issues_expiring_token_and_updates_last_login(): void
    {
        $this->freezeSecond();

        $user = User::factory()->createOne([
            'is_admin' => false,
            'password' => Hash::make('password'),
        ]);

        $this->post('api/v1/user/login', ['email' => $user->email, 'password' => 'password'])->assertOk();

        $this->assertNotNull($user->fresh()->last_login_at);
        $this->assertSame(1, $user->tokens()->count());
        $this->assertTrue($user->tokens()->sole()->expires_at->equalTo(now()->addMinutes((int) config('sanctum.expiration'))));
    }
}
