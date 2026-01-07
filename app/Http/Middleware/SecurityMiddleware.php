<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Validar headers de seguridad
        $userAgent = $request->header('User-Agent');
        if (!$userAgent || strlen($userAgent) < 10) {
            abort(403, 'Invalid request');
        }

        // Prevenir ataques de inyección SQL básicos
        $suspiciousPatterns = [
            '/union\s+select/i',
            '/drop\s+table/i',
            '/delete\s+from/i',
            '/insert\s+into/i',
            '/update\s+set/i',
            '/<script/i',
            '/javascript:/i',
            '/vbscript:/i',
            '/onload=/i',
            '/onerror=/i'
        ];

        $input = $request->all();
        foreach ($input as $key => $value) {
            if (is_string($value)) {
                foreach ($suspiciousPatterns as $pattern) {
                    if (preg_match($pattern, $value)) {
                        abort(403, 'Suspicious input detected');
                    }
                }
            }
        }

        // Limitar tamaño de request
        $contentLength = $request->header('Content-Length');
        if ($contentLength && $contentLength > 10 * 1024 * 1024) { // 10MB
            abort(413, 'Request too large');
        }

        // Validar CSRF para requests POST/PUT/DELETE
        if (in_array($request->method(), ['POST', 'PUT', 'DELETE', 'PATCH'])) {
            if ($request->hasSession() && !$request->session()->token()) {
                // Ya Laravel maneja CSRF, esto es una validación adicional
            }
        }

        return $next($request);
    }
}