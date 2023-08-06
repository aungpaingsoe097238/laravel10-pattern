<?php

namespace App\Utlis;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

class Json
{
    /**
     * Return success message and data
     */
    public static function success($data = null, $message = null, $statusCode = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' =>  true
        ], $statusCode);
    }

    /**
     * Return error message
     */
    public static function error($message = null, $statusCode = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'status'  => false
        ], $statusCode);
    }

    /**
     * Return only message
     */
    public static function message($message = null, $status = true, $statusCode = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'status'  => $status
        ], $statusCode);
    }

    /**
     *  Return response from resource
     */
    public static function resource($request)
    {
        $routeName = Route::currentRouteName();
        $uri = substr($routeName, 0, strpos($routeName, '.')); // Slice current route uri (eg:posts)
        return [
            'message' => match ($routeName) {
                $uri . '.index' => $uri . ' list successfully.',
                $uri . '.store' => $uri . ' create successfully.',
                $uri . '.show' => $uri . ' details retrieved successfully.',
                $uri . '.update' => $uri . ' updated successfully.',
                $uri . '.destroy' => $uri . ' deleted successfully.',
                default => 'Unknown route',
            },
            'status' => in_array($routeName, [$uri . '.index', $uri . '.store', $uri . '.show', $uri . '.update', $uri . '.destroy']),
        ];
    }
}
