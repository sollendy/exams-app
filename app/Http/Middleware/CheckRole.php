<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    
    /**
     * Gestisce una richiesta in entrata.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  mixed ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
      if (Auth::check()) {
            $userRole = Auth::user()->role;

            if (!in_array($userRole, $roles)) {
                abort(403, 'Accesso negato');
            }
        } else {
            abort(403, 'Accesso negato');
        }


        return $next($request);
    }
}
