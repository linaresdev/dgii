<?php
namespace DGII\Http\Middleware\Web;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use Closure;
use Illuminate\Support\Facades\Auth;

class Login {

    protected $exerts = [
        "login"
    ];

    public function handle( $request, Closure $next, $guard = 'web')
    {
        if( ($AUTH = Auth::guard($guard))->guest() && !$this->isExert($request) )
        {
            return redirect("login");
        }

        return $next( $request );
    }

    public function isExert($request) {

        $out = false;
        
        foreach( $this->exerts as $exert ) {
            if(\Str::is($exert, $request->path())) {
                return true;
            }
        }

        return $out;
    }

}