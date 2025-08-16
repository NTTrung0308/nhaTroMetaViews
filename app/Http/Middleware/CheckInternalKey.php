<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckInternalKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Nếu session chưa có xác thực thì redirect về form nhập key
        if (!$request->session()->get('internal_key_verified', false)) {
            return redirect()->route('internal.key.form');
        }

        return $next($request);
    }
}
