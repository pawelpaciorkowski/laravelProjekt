<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsModerator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Sprawdź, czy użytkownik jest adminem LUB moderatorem
        if (Auth::check() && in_array(Auth::user()->role, ['admin', 'moderator'])) {
            return $next($request);
        }

        abort(403, 'Brak uprawnień do wykonania tej akcji.');
    }
}
