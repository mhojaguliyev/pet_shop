<?php

namespace Tests\Feature;

use App\Models\Auth\JwtToken;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

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
     * Test an invalid jwt token is rendered as a json response.
     */
    public function test_invalid_token_returns_json_401(): void
    {
        $this->get('api/v1/user?token=invalid-token')
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
        $this->delete('api/v1/categories')->assertInternalServerError()
            ->assertJsonStructure(['message', 'data']);
    }

    /**
     * Test the "user_type" middleware alias rejects users of another type.
     */
    public function test_user_type_middleware_rejects_admin_on_user_route(): void
    {
        $admin = User::factory()->createOne(['is_admin' => true]);
        $token = JWTAuth::fromUser($admin);

        $this->get('api/v1/user?token='.$token)
            ->assertForbidden()
            ->assertExactJson(['message' => 'Forbidden', 'data' => []]);
    }

    /**
     * Test login event listener is discovered and the jwt token observer sets expiry.
     */
    public function test_login_stores_jwt_token_with_expiry(): void
    {
        $this->freezeSecond();

        $user = User::factory()->createOne([
            'is_admin' => false,
            'password' => Hash::make('password'),
        ]);

        $this->post('api/v1/user/login', ['email' => $user->email, 'password' => 'password'])->assertOk();

        $this->assertNotNull($user->fresh()->last_login_at);
        $this->assertSame(1, JwtToken::query()->where('user_uuid', $user->uuid)->count());

        $jwtToken = JwtToken::query()->where('user_uuid', $user->uuid)->firstOrFail();
        $this->assertTrue($jwtToken->expires_at->equalTo(now()->addMinutes((int) config('jwt.ttl'))));
    }
}
