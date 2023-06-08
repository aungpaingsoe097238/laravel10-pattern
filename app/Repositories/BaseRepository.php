<?php

namespace App\Repositories;

class BaseRepository
{
    public static function json($message='successfully',$status=1,$code=200)
    {
        return response()->json([
            'message' => $message,
            'status'  => $status, 
        ],$code);
    }
}
