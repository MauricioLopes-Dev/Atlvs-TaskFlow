<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminUser
{
    public function handle(Request $request, Closure $next): Response
    {
        $adminEmail = config('app.admin_email', 'admin@empresa.com');

        if (!$request->user() || $request->user()->email !== $adminEmail) {
            abort(403, 'Acesso restrito ao administrador.');
        }

        return $next($request);
    }
}