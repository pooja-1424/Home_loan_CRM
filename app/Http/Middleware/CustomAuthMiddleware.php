<?php

namespace App\Http\Middleware;

use Closure;

class CustomAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        // Implement your custom authentication logic here
         if (! $request->expectsJson()) {
            return redirect()->route('login');
        }
}
}
