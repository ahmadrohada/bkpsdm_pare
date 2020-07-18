<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class ApiAccess {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{

		if ( $request['access_token'] === '0pMroLcGdpj2FqxBn7NKK4ZB4UynqkjkQNtDrUf4redo50f1u0SOtpShazUm' )
		{
            return $next($request);
			
		}else{
            return response()->json(['message'     => 'Token is not valid',],401);
        }

	}

}
