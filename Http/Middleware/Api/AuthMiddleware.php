<?php
namespace DGII\Http\Middleware\Api;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthMiddleware extends Middleware {

    protected $exerts = [];

    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : "api/nologin";
    }

    // public function handle( $request, Closure $next, $guard = 'web') 
    // { 
    //     //dd(Auth::check());
    //     // $user = $request->user();
    //     // return response($user);
    //     return $next( $request );
    // }

}