<?php

namespace App\Http\Middleware;

use Closure;
use App\token_model;
class token
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
       
        $f=token_model::where('token','=',$request->token)->exists();
        if ($f) {
            return $next($request);
        } else {
            return response()->json([
                'msg'=>'fails Token wronggs'
            ],401);
        }
        
    }
}
