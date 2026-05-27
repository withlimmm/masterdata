<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Add security headers to every response.
     * This hardens the application against common web attacks.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $isAdmin = str_starts_with($request->path(), 'admin');

        // X-Frame-Options: Prevent clickjacking
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // X-Content-Type-Options: Prevent MIME sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // X-XSS-Protection: Legacy XSS protection
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Referrer-Policy: Control referrer info
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Permissions-Policy: Restrict browser features
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(self), payment=()');

        // Remove X-Powered-By header (don't expose tech stack)
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        // Content Security Policy
        // In development, allow Vite dev server and additional CDNs
        $scriptSrc = "'self' 'unsafe-inline' 'unsafe-eval' https://www.googletagmanager.com https://www.google-analytics.com https://fonts.googleapis.com https://cdn.jsdelivr.net https://www.google.com/recaptcha/ https://www.gstatic.com/recaptcha/ https://connect.facebook.net";
        $styleSrc = "'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net";
        $connectSrc = "'self' https://www.google-analytics.com https://region1.google-analytics.com https://cdn.jsdelivr.net https://www.facebook.com https://www.google.com/recaptcha/";

        // Allow Vite dev server in development (localhost works for both IPv4 and IPv6)
        if (app()->environment('local')) {
            $scriptSrc .= " http://localhost:5173 ws://localhost:5173";
            $styleSrc .= " http://localhost:5173";
            $connectSrc .= " http://localhost:5173 ws://localhost:5173";
        }

        $csp = implode('; ', [
            "default-src 'self'",
            "script-src $scriptSrc",
            "style-src $styleSrc",
            "img-src 'self' data: https: blob:",
            "font-src 'self' data: https://fonts.gstatic.com",
            "connect-src $connectSrc",
            "frame-src https://www.google.com https://www.googletagmanager.com https://www.facebook.com",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
            "upgrade-insecure-requests",
        ]);

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
