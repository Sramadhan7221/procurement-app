<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('user_id') || empty(session('user_id'))) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Unauthorized. Session expired or invalid.',
                ], Response::HTTP_UNAUTHORIZED);
            }

            return redirect()->route('auth')->withErrors([
                'session' => 'Your session has expired. Please log in again.',
            ]);
        }

        return $next($request);
    }
}
