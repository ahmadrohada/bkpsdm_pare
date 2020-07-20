<?php namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * @var array
	 */
	protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
        'auth' 				=> \App\Http\Middleware\Authenticate::class,
        'auth.basic' 		=> \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' 			=> \App\Http\Middleware\RedirectIfAuthenticated::class,
        'currentUser' 		=> \App\Http\Middleware\CheckCurrentUser::class,
        'administrator' 	=> \App\Http\Middleware\Administrator::class,
		'personal' 			=> \App\Http\Middleware\Personal::class,
		'skpd' 				=> \App\Http\Middleware\Skpd::class,
		'puskesmas' 		=> \App\Http\Middleware\Puskesmas::class,
		'non_pns' 			=> \App\Http\Middleware\NonPns::class,
		'auth.api' 			=> \App\Http\Middleware\ApiAccess::class,
	];

}
