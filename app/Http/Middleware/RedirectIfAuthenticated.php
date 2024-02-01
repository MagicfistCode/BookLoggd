<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        $user = Auth::user();

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if ($user && $user->role === 'admin'){
                    return redirect()->route('book.index'); // Redirect admins to admin dashboard
                } else {
                    return redirect()->route('post.display'); // Redirect regular users to user dashboard
                }
            }
        }

        return $next($request);
    }
}
