<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;

class AccessControlList
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $route = $request->route()->getName();
        $cache = Cache::get('actions_' . auth()->user()->id);
        if ($cache == null) {
            return response()->json([
                'success' => false,
                'status'  => 'negative',
                'message' => message('MSG009'),
            ], 401);
        }
        if (!in_array($route, $cache) && !in_array('*', $cache) && $route) {
            return response()->json([
                'success' => false,
                'status'  => 'negative',
                'message' => message('MSG010'),
            ], 403);
        }
        return $next($request);
    }
}
