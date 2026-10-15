<?php

namespace App\Http\Middleware;

use Closure;

class SecurityHeaders
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);


        $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self'; script-src 'self' 'unsafe-inline' https://unpkg.com https://cdnjs.cloudflare.com https://s3.tradingview.com https://www.tradingview.com https://www.tradingview-widget.com; style-src 'self' 'unsafe-inline' https://unpkg.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net; font-src 'self' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net; img-src 'self' data: https:; frame-src 'self' https://www.google.com https://maps.google.com https://www.tradingview-widget.com https://s.tradingview.com; connect-src 'self' https://*.tradingview.com;"
        );


        $response->headers->set(
            'Strict-Transport-Security',
            'max-age=31536000; includeSubDomains'
        );


        $response->headers->set(
            'X-Frame-Options',
            'SAMEORIGIN'
        );


        $response->headers->set(
            'Cross-Origin-Opener-Policy',
            'same-origin-allow-popups'
        );


        return $response;
    }
}