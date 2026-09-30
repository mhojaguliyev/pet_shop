<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

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
        JWTAuth::setToken($response->json('data.token'))->checkOrFail();
    }

    /**
     * Test if user can log out trough internal api.
     */
    public function test_user_logout_response(): void
    {
        $user = User::factory()->createOne([
            'is_admin' => false,
        ]);
        $token = JWTAuth::fromUser($user);

        $this->post('api/v1/user/logout?token='.$token)->assertOk()
            ->assertJsonStructure(['message']);

        $this->assertGuest('api');
    }

    /**
     * Test user profile response
     */
    public function test_user_profile_response(): void
    {
        $user = User::factory()->createOne([
            'is_admin' => false,
        ]);
        $token = JWTAuth::fromUser($user);

        $response = $this->get('api/v1/user?token='.$token)->assertOk()
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
}
