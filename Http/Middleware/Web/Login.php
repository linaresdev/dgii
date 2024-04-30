<?php
namespace DGII\Http\Middleware\Web;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use Closure;
use DGII\Facade\Alert;
use Illuminate\Support\Facades\Auth;

class Login {

    protected $exerts = [
    ];

    public function handle( $request, Closure $next, $guard = 'web')    
    {
        if( ($AUTH = Auth::guard($guard))->guest() && !$this->isExert($request) )
        {
            if( __segment(1, "admin") OR __segment(1, "entity") )
            {
                $errors = Alert::addErrors("warning", [
                    __("auth.required")
                ]);
                
                return redirect("login")->withErrors($errors)->withInput();
            }            
        }
        else {

            $user = $request->user();

            if( __segment(1, "login") ) {
                return back();
            }

            if( !$request->user()->isGroup("admin") && __segment(1, "admin") ) {
                return back();
            }

           
            if( __segment(1, "entity") && ($user->isTypeGroup("entity-group") == true ) )
            {
                if( !$user->isGroup(__segment(2)) && (count(__segment()) > 1) ) { 
                    return abort(404);
                }
                
            }
            else {
                return back();
            }

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