<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class DatabaseTransactionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        DB::beginTransaction();

        try {
            $response = $next($request);

            if ($response->getStatusCode() >= 400) {
                DB::rollBack();
            } else {
                DB::commit();
            }

            return $response;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
