<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\UserModel as User;

class TokenCheck
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

        if (!$request->hasHeader('_token')) {
          return response([
            'status'=>'error',
            'message'=>'You must login to get api token'
          ],403);
        }
        $cek = User::where('remember_token',$request->header('_token'))->first();
        if (!count($cek)) {
          return response([
            'status'=>'error',
            'message'=>'Api token not correct'
          ],403);
        }
        return $next($request);
    }
}
