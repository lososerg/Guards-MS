<?php namespace App\Http\Middleware;

use Closure;
use Auth;
use Log;

class AccessMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
  
    if (Auth::guest()) {
      return redirect('auth/login');
    } elseif ((Auth::user()->access < 1)) {
      return redirect('noaccessgranted');
    }
    /*elseif (Auth::user()->access < 1) {
      return redirect('home');
    }
    */
    
    if (isset(Auth::user()->language) and !empty(Auth::user()->language)) {
          app()->setLocale(Auth::user()->language);
      }
		return $next($request);
	}

}
