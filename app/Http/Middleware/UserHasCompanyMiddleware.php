<?php namespace App\Http\Middleware;

use Closure;
use Auth;
use Redirect;

class UserHasCompanyMiddleware {
    
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
  public function handle($request, Closure $next)
  {
    if(Auth::User()->company_id == '' || Auth::User()->company_user_status != 'active') {
      return Redirect::to('welcome/company');
    }
    return $next($request);
  }

}