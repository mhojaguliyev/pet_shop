<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Events\LoggedIn;
use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Api\v1\LoginRequest;

class AuthController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth.jwt', ['except' => ['login']]);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();
        $credentials['is_admin'] = false;

        // auth check
        if (!$token = auth()->attempt($credentials)) {
            return $this->sendResponse('Unauthorized', code: 401);
        }

        // fire event
        LoggedIn::dispatch(auth()->user(), $token);

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
}
