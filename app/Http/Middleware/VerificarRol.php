<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarRol
{
    public function handle(
        Request $request,
        Closure $next,
        string $rol
    ): Response {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        if ($request->user()->rol !== $rol) {
            abort(403, 'No tienes permiso para entrar a esta página.');
        }

        $respuesta = $next($request);

        $respuesta->headers->set(
            'Cache-Control',
            'no-store, private'
        );

        return $respuesta;
    }
}