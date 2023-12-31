<?php

namespace App\Http\Middleware;

use App\Models\User;
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
        /** @var User|null $user */
        $user = auth()->user();
        if ($user && $user->is_admin == $type) {
            return $next($request);
        }

        abort(403, 'Forbidden');
    }
}
