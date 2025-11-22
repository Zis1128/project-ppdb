<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PanitiaMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('filament.panitia.auth.login');
        }

        if (!auth()->user()->hasAnyRole(['admin', 'panitia'])) {
            abort(403, 'Unauthorized action.');
        }

        if (!auth()->user()->is_active) {
            auth()->logout();
            return redirect()->route('filament.panitia.auth.login')
                ->with('error', 'Akun Anda tidak aktif.');
        }

        return $next($request);
    }
}