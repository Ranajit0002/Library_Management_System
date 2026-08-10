<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MemberMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && in_array($request->user()->role, ['Member', 'Admin'])) {
            return $next($request);
        }

        abort(403, 'Unauthorized action. Member access required.');
    }
}