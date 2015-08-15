<?php namespace App\Http\Middleware;

use Closure;
use Auth;
use Redirect;

class ProjectIdCheckMiddleware {
    
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
  public function handle($request, Closure $next)
  {
    if(Auth::User()->company_user_access != 'admin') {
      return Redirect::to('settings/profile');
    }
    return $next($request);
  }

}