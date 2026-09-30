<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * Test if user can log in trough internal api.
     */
    public function test_user_login_response(): void
    {
        $user = User::factory()->createOne([
            'is_admin' => false,
            'password' => Hash::make('password'),
        ]);
        $response = $this->post(
            '/api/v1/user/login',
            [
                'email' => $user->email,
                'password' => 'password',
            ]
        );
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'data' => [
                'token',
                'tokenType',
            ],
        ]);
        $this->assertTrue(PersonalAccessToken::findToken($response->json('data.token'))?->tokenable->is($user));
    }

    /**
     * Test if user can log out trough internal api.
     */
    public function test_user_logout_response(): void
    {
        $user = User::factory()->createOne([
            'is_admin' => false,
        ]);
        $token = $user->createToken('api')->plainTextToken;

        $this->withToken($token)->post('api/v1/user/logout')->assertOk()
            ->assertJsonStructure(['message']);

        $this->assertDatabaseCount('personal_access_tokens', 0);
    }

    /**
     * Test user profile response
     */
    public function test_user_profile_response(): void
    {
        $user = User::factory()->createOne([
            'is_admin' => false,
        ]);
        $token = $user->createToken('api')->plainTextToken;

        $response = $this->withToken($token)->get('api/v1/user')->assertOk()
            ->assertJsonStructure([
                'message',
                'data' => [
                    'firstName',
                    'lastName',
                    'email',
                ],
            ]);

        $this->assertEquals($response->json('data.email'), $user->email);
    }

    /**
     * Test login fails with a wrong password.
     */
    public function test_user_login_fails_with_wrong_password(): void
    {
        $user = User::factory()->createOne(['is_admin' => false]);

        $this->post('/api/v1/user/login', ['email' => $user->email, 'password' => 'wrong-password'])
            ->assertUnauthorized()
            ->assertExactJson(['message' => 'Unauthorized', 'data' => []]);

        $this->assertDatabaseCount('personal_access_tokens', 0);
    }

    /**
     * Test admins cannot log in through the user login endpoint.
     */
    public function test_admin_cannot_log_in_as_user(): void
    {
        $admin = User::factory()->createOne(['is_admin' => true]);

        $this->post('/api/v1/user/login', ['email' => $admin->email, 'password' => 'password'])
            ->assertUnauthorized();
    }

    /**
     * Test expired tokens are rejected.
     */
    public function test_expired_token_is_rejected(): void
    {
        $user = User::factory()->createOne(['is_admin' => false]);
        $token = $user->createToken('api', expiresAt: now()->addMinute())->plainTextToken;

        $this->travel(2)->minutes();

        $this->withToken($token)->get('api/v1/user')->assertUnauthorized();
    }
}
