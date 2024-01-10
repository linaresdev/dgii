<?php
namespace DGII\Http\Support;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use DGII\Facade\Alert;

class Auth
{

    public function webLogin() {

        $data["title"] = __("words.authentication");

        return $data;
    }

    public function guestLogin($request)
    {
        $validator   = validator([],[]);

        if( ($guard = auth("web"))->attempt($request->except('_token')) ) 
        {
            $user = $guard->user();

            for( $i=-0; $i<5; $i++) {
                if( ($i != 1) && $user->activated == $i )
                {
                    $user->news("login", __("words.rejected"), [
                        "message" => __("account.$i")
                    ]);

                    $guard->logout();
                    $validator->errors()->add('login', __("account.$i"));
                    return back()->withErrors($validator)->withInput();
                }
            }

            if( $user->activated > 4 )
            {
                $user->news("login", "words.rejected", [
                    "message"   => __("access.fishy").', '. __("account.".$user->activated)            
                ]);

                $guard->logout();

                $validator->errors()->add('login', __("auth.bad"));
                return back()->withErrors($validator)->withInput();
            }

            $user->news("login", "words.aprobed");
            return redirect("admin");
        }

        $validator->errors()->add('login', __("auth.bad"));

        return back()->withErrors($validator)->withInput();
    }

    public function webLogout($auth)
    {
        $auth->user()->news("logout", "words.approved", [
            "message" => "auth.logout"
        ]);

        $auth->logout();       
        
        return redirect("login");
    }

    public function guestAuth($request)
    {
        dd($request->all());
    }

    public function getSeed() {
        return "Hola mundo";
    }
}