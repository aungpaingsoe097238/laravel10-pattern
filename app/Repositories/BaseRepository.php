<?php

namespace App\Repositories;

use Illuminate\Http\Response;

class BaseRepository
{
    public static function json($data = [], $message = 'Successfully', $status = 1, $code = Response::HTTP_OK)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status'  => $status,
        ], $code);
    }

    public static function notFound($message = "Data not found", $status = 2, $code = Response::HTTP_NOT_FOUND)
    {
        return response()->json([
            'message' => $message,
            'status'  => $status,
        ], $code);
    }

    public static function error($message = 'Failed', $status = 2, $code = Response::HTTP_BAD_REQUEST)
    {
        return response()->json([
            'message' => $message,
            'status'  => $status
        ], $code);
    }

    public static function success($message = 'Successfully', $status = 1, $code = Response::HTTP_OK)
    {
        return response()->json([
            'message' => $message,
            'status'  => $status
        ], $code);
    }

    public static function deleteSuccess($message = 'Data delete successfully', $status = 1, $code = Response::HTTP_OK)
    {
        return response()->json([
            'message' => $message,
            'status'  => $status,
        ], $code);
    }
}
