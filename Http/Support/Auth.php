<?php
namespace DGII\Http\Support;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/


class Auth
{

    public function webLogin() {

        $data["title"] = __("words.authentication");

        return $data;
    }

    public function guestLogin($request)
    {
        $validator   = validator([],[]);

        if( auth("web")->attempt($request->except('_token')) ) 
        {
            return redirect("admin");
        }

        $validator->errors()->add('login', __("auth.bad"));

        return back()->withErrors($validator)->withInput();
    }

    public function webLogout($auth)
    {
        $auth->logout();
        
        return redirect("login");
    }

    public function geuestAuth($request)
    {
        dd($request->all());
    }

    public function getSeed() {
        return "Hola mundo";
    }
}