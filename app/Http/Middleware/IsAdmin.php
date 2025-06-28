<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- DODANY IMPORT
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Sprawdź, czy użytkownik jest zalogowany i ma rolę 'admin'
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        abort(403, 'Brak uprawnień do wykonania tej akcji.');
    }
}
