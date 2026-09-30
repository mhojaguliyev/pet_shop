<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Enums\UserType;
use App\Events\LoggedIn;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\v1\LoginRequest;
use App\Http\Resources\Api\v1\UserResource;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;

class AuthController extends ApiController implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     *
     * @return array<int, Middleware>
     */
    public static function middleware(): array
    {
        return [
            new Middleware(['auth:sanctum', 'user_type:'.UserType::User->value], except: ['login']),
        ];
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::query()
            ->where('email', $request->validated('email'))
            ->where('is_admin', false)
            ->first();

        if (! $user || ! Hash::check($request->validated('password'), $user->password)) {
            return $this->sendResponse('Unauthorized', code: 401);
        }

        $token = $user->createToken('api', expiresAt: now()->addMinutes((int) config('sanctum.expiration')))->plainTextToken;

        event(new LoggedIn($user));

        return $this->sendResponse(data: ['token' => $token, 'tokenType' => 'bearer']);
    }

    public function logout(#[CurrentUser] User $user): JsonResponse
    {
        $user->currentAccessToken()->delete();

        return $this->sendResponse('Successfully logged out');
    }

    public function profile(#[CurrentUser] User $user): JsonResponse
    {
        return $this->sendResponse(data: new UserResource($user));
    }
}
