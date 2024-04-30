<?php
namespace DGII\Http\Middleware;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

use Closure;
use DGII\Facade\Alert;
use Illuminate\Support\Facades\Auth;

class EntityMiddleware {

    protected $exerts = [];

    public function handle( $request, Closure $next, $guard = 'web')
    { 
        if( ($AUTH = Auth::guard($guard))->guest() && !$this->isExert($request) )
        {
            // $errors = Alert::addErrors("warning", [
            //     __("auth.required")
            // ]);
            
            // return redirect("/login")->withErrors($errors)->withInput();
        }
        else{

            // if( $request->user()->entities()->count() == 0 )
            // {
            //     return redirect("/");
            // }
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