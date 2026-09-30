<?php

use App\Http\Controllers\ApiController;
use App\Http\Middleware\UserTypeMiddleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->throttleApi();
        $middleware->redirectGuestsTo(null);

        $middleware->alias([
            'user_type' => UserTypeMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $apiController = new ApiController;

        $exceptions->render(fn (TokenBlacklistedException $e): JsonResponse => $apiController->sendResponse($e->getMessage(), code: 500));
        $exceptions->render(fn (JWTException $e): JsonResponse => $apiController->sendResponse('Unauthenticated', code: 401));
        $exceptions->render(fn (AuthenticationException $e): JsonResponse => $apiController->sendResponse('Unauthenticated', code: 401));
        $exceptions->render(fn (MethodNotAllowedHttpException $e): JsonResponse => $apiController->sendResponse($e->getMessage(), code: 500));
        $exceptions->render(fn (HttpException $e): JsonResponse => $apiController->sendResponse($e->getMessage(), code: $e->getStatusCode()));
    })->create();
