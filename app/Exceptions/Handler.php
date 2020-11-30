<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Throwable $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthenticationException) {
            if ($request->wantsJson()) {
                return $this->apiResponse(null, 'Unauthenticated, you must be logged in to do this action', 401, 0);
            } else {
                return parent::render($request, $exception);
            }
        }

        if ($exception instanceof NotFoundHttpException) {
            if ($request->wantsJson()) {
                return $this->apiResponse(null, 'The specified URl cannot be found', 404, 0);
            } else {
                return parent::render($request, $exception);
            }
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            if ($request->wantsJson()) {
                return $this->apiResponse(null, 'Method is not allowed for the requested route', 405, 0);
            } else {
                return parent::render($request, $exception);
            }
        }
        if (Config::get('app.debug')){
            return parent::render($request, $exception);
        }

        if ($request->wantsJson()) {
            return $this->apiResponse(null, 'Unexpected Exception. Try later', 500, 0);
        } else {
            return parent::render($request, $exception);
        }

    }
}
