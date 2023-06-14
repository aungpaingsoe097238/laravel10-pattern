<?php

namespace App\Repositories;

class BaseRepository
{
    public static function json($data=[],$message='successfully',$status=1,$code=200)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status'  => $status,
        ],$code);
    }

    public static function deleteSuccess($message='data delete successfully',$status=1,$code=200)
    {
        return response()->json([
            'message' => $message,
            'status'  => $status,
        ],$code);
    }
}
