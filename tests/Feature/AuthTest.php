<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * Test if user can log in trough internal api.
     *
     * @return void
     */
    public function test_user_login_response(): void
    {
        $user = User::factory()->createOne([
            'is_admin' => false,
        ]);
        $response = $this->post(
            '/api/v1/user/login',
            [
                'email' => $user->email,
                'password' => 'password',
            ]
        );
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'data' => [
                'token',
                'tokenType',
            ]
        ]);
        \JWTAuth::setToken($response->json('data.token'))->checkOrFail();
    }


    /**
     * Test if user can log out trough internal api.
     *
     * @return void
     */
    public function test_user_logout_response()
    {
        $user = User::where('is_admin', false)->first();
        $token = \JWTAuth::fromUser($user);

        $this->post('api/v1/user/logout?token=' . $token)
            ->assertStatus(200)
            ->assertJsonStructure(['message']);

        $this->assertGuest('api');
    }

    /**
     * Test user profile response
     *
     * @return void
     */
    public function test_user_profile_response(): void
    {
        $user = User::where('is_admin', false)->first();
        $token = \JWTAuth::fromUser($user);

        $response = $this->get('api/v1/user?token=' . $token)
            ->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'firstName',
                    'lastName',
                    'email',
                ]
            ]);

        $this->assertEquals($response->json('data.email'), $user->email);
    }
}
