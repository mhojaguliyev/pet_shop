<?php

namespace App\Exceptions;

use App\Http\Controllers\ApiController;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $apiController = new ApiController();

        // jwt auth exceptions
        $this->renderable(fn (TokenBlacklistedException $e) => $apiController->sendResponse($e->getMessage(), code: 500));
        $this->renderable(fn (JWTException $e) => $apiController->sendResponse('Unauthenticated', code: 401));
        $this->renderable(fn (AuthenticationException $e) => $apiController->sendResponse('Unauthenticated', code: 401));
        $this->renderable(fn (AuthenticationException $e) => $apiController->sendResponse('Unauthenticated', code: 401));
        $this->renderable(fn (MethodNotAllowedHttpException $e) => $apiController->sendResponse($e->getMessage(), code: 500));
        $this->renderable(fn (HttpException $e) => $apiController->sendResponse($e->getMessage(), code: $e->getStatusCode()));

        $this->reportable(function (Throwable $e) {

        });
    }
}
