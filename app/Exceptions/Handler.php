<?php

namespace App\Exceptions;

use Throwable;
use OSS\Core\OssException;
use BadMethodCallException;
use Illuminate\Http\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

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
        if ($e instanceof UnauthorizedException) {
            return response(['status' => false, 'message' => 'User does not have the right permissions.'], Response::HTTP_UNAUTHORIZED);
        }
        if ($e instanceof AuthenticationException) {
            return $this->unauthenticated($request, $e);
        }
        if ($e instanceof AuthorizationException) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], Response::HTTP_UNAUTHORIZED);
        }
        if ($e instanceof ModelNotFoundException) {
            // Change model name to lower case
            $message = strtolower(class_basename($e->getModel()));
            return response()->json(['status' => false, 'message' => "Can't find $message"], Response::HTTP_NOT_FOUND);
        }
        if ($e instanceof NotFoundHttpException) {
            return response()->json(['status' => false, 'message' => 'Incorect route.'], Response::HTTP_NOT_FOUND);
        }
        if ($e instanceof RoleDoesNotExist) {
            return response()->json(['status' => false, 'message' => 'Role not found.'], Response::HTTP_BAD_REQUEST);
        }
        // if ($e instanceof BadMethodCallException) {
        //     return response()->json(['status' => false, 'message' => 'Method not found or invalid method call.'], Response::HTTP_BAD_REQUEST);
        // }
        // if ($e instanceof OssException) {
        //     return response()->json(['status' => false, 'message' => 'Image upload failed. Please try again later..'], Response::HTTP_BAD_REQUEST);
        // }
        if ($e instanceof MethodNotAllowedHttpException) {
            $method = $request->getMethod();
            $message = sprintf('%s method not allowed', $method);

            return response()->json(['status' => false, 'message' => $message], Response::HTTP_METHOD_NOT_ALLOWED);
        }

        return parent::render($request, $e);
    }
}
