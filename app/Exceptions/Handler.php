<?php namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	/* public function render($request, Exception $e)
	{
		
		return parent::render($request, $e);
	}

	//hadler error untuk ambil data dari SIAP
	public function render($request, Exception $exception)
	{
		if ($exception instanceof ModelNotFoundException && $request->wantsJson()) {
			return response()->json(['message' => 'Not Found!'], 404);
		}
		return parent::render($request, $exception);
	}  */

	public function render($request, Exception $exception)
{
    if($this->isHttpException($exception)){
        switch ($exception->getStatusCode()) {
			case 500:
                return response()->view('errors.500', [], $exception->getStatusCode());
                break;
            case 404:
                return response()->view('errors.404', [], $exception->getStatusCode());
                break;
            case 405:
                return response()->view('errors.405', [], $exception->getStatusCode());
                break;
        }
    }        
    return parent::render($request, $exception);
}
}
