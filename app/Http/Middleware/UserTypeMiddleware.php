<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserTypeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next, int $type): Response
    {
        $user = auth()->user();
        if ($user && property_exists($user, 'is_admin') && $user->is_admin == $type) {
            return $next($request);
        }

        abort(403, 'Forbidden');
    }
}
