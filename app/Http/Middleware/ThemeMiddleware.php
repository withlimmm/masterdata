<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ThemeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('theme')) {
            $theme = $request->query('theme');
            if (in_array($theme, ['default', 'premium'])) {
                session(['theme' => $theme]);
            }
        }

        return $next($request);
    }
}
