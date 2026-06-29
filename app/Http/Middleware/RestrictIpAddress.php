<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictIpAddress
{
    public function handle(Request $request, Closure $next): Response
    {
        $allowedIps = [
            '127.0.0.1',
            '122.1.114.1',
        ];

        if (!in_array($request->ip(), $allowedIps)) {
            abort(403, 'Bạn không có quyền truy cập hệ thống từ địa chỉ IP này.');
        }

        return $next($request);
    }
}
