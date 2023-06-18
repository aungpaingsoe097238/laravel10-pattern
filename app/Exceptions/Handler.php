<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {

        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof AuthenticationException) {
            return $this->unauthenticated($request, $e);
        }
        if ($e instanceof AuthorizationException) {
            return response()->json(['status' => 2, 'message' => $e->getMessage()], Response::HTTP_UNAUTHORIZED);
        }
        if ($e instanceof UnauthorizedException) {
            return response()->json(['status' => 2, 'message' => $e->getMessage()], Response::HTTP_UNAUTHORIZED);
        }
        if ($e instanceof ModelNotFoundException) {
            // Change model name to lower case
            $message = strtolower(class_basename($e->getModel()));
            return response()->json(['status' => false, 'message' => "Can't find $message"], Response::HTTP_NOT_FOUND);
        }
    }
}
