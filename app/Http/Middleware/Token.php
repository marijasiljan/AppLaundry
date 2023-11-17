<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Token
{
    /**
     * Handle an incoming request.
     *
     *
     *
     * @param Request $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle(Request $request, Closure $next)
    {

        $request->headers->set("Accept", "application/json");
        if ($request->has('api_token')) {
            $request->headers->set('Authorization', $request->get('api_token'));
        }
        $user = User::whereToken($request->headers->get('authorization'))->first();
        if ($user && $user->token != null)
        {

            Auth::login($user);
            return $next($request);
        }
        return response()->json(['status'=>false, 'message'=>__('lang.unauthenticated'),'token'=>true], 401);
    }
}
