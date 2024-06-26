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
            if( __segment(1, "logout") ) {
                abort(404);
            }
            
            if( __segment(1, "admin") OR __segment(1, "entity") )
            {                
                return redirect("login");
            }            
        }
        else {

            $user = $request->user();

            if( __segment(1, "login") ) {
                return redirect()->to('/');
            }

            if( !$request->user()->isGroup("admin") && __segment(1, "admin") ) {
                return back();
            }

           
            if( __segment(1, "entity")  )
            {

                if( $user->isTypeGroup("entity-group") )
                {
                    if( count( __segment() ) > 1 ) { 
                        if( !$user->isGroup(__segment(2)) )
                        {
                            abort(404);
                        }
                    }
                }
                else {
                    abort(404);
                }               
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