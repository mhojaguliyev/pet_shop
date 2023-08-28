<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Enums\UserType;
use App\Events\LoggedIn;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\v1\LoginRequest;
use App\Http\Resources\Api\v1\UserResource;
use Illuminate\Http\JsonResponse;

class AuthController extends ApiController
{
    public function __construct()
    {
        $this->middleware(
            ['auth:api', 'user_type:' . UserType::USER->value],
            ['except' => ['login']]
        );
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();
        $credentials['is_admin'] = false;

        // auth check
        if (! $token = auth()->attempt($credentials)) {
            return $this->sendResponse('Unauthorized', code: 401);
        }

        // fire event
        if (auth()->user() !== null && is_string($token)) {
            LoggedIn::dispatch(auth()->user(), $token);
        }

        // send response
        return $this->sendResponse(data: ['token' => $token, 'tokenType' => 'bearer']);
    }

    public function logout(): JsonResponse
    {
        // action
        auth()->logout();

        // send response
        return $this->sendResponse('Successfully logged out');
    }

    public function profile(): JsonResponse
    {
        $user = auth()->user();
        return $this->sendResponse(data: new UserResource($user));
    }
}
