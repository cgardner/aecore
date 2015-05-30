<?php namespace App\Http\Middleware;

use Auth;
use Closure;
use Redirect;

class UserStatusMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::User() == null) {
            return Redirect::to('/');
        }

        if (Auth::User()->status != 'active') {
            Auth::logout();
            return Redirect::to('reactivate');
        }
        return $next($request);
    }

}