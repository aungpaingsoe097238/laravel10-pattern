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
     *  Return response from resource
     */
    public static function resource($request)
    {
        $routeName = Route::currentRouteName();
        return [
            'message' => match ($routeName) {
                'posts.store' => 'Post create successfully',
                'posts.show' => 'Post details retrieved successfully',
                'posts.update' => 'Post updated successfully',
                'posts.destroy' => 'Post deleted successfully',
                default => 'Unknown route',
            },
            'status' => in_array($routeName, ['posts.store', 'posts.show', 'posts.update', 'posts.destroy']),
        ];
    }
}
