<?php
namespace DGII\Http\Middleware\Api;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthMiddleware {

    protected $exerts = [];

    public function handle( $request, Closure $next, $guard = 'web') 
    { 
        
        // $user = $request->user();
        // return response($user);
        return $next( $request );
    }

}