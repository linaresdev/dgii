<?php
namespace DGII\Http\Support\Admin;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

use DGII\Model\Term;
use DGII\Facade\Dgii;
use DGII\Support\Flash;
use DGII\Button\Facade\Btn;
use DGII\User\Model\Store;

class UserSupport
{
    protected $user;

    public function __construct(Store $user)
    {
        $this->user = $user;

        ## RESOURCES
        Dgii::addUrl([
            "{users}" => "admin/users"
        ]);
    }   

    public function share() 
    {
        return [];
    }

    public function index()
    {
        $data['title'] = __("words.accounts-users");
        $data["users"]  = $this->user->paginate(6);

        return $data;
    }

    public function getRegister()
    {
        $data['title']      = __("register.users");
        $data["container"]  = "col-xl-6 offset-xl-3 col-lg-10 offset-md-1";   

        return $data;
    }

    public function postRegister($request)
    {
        $data               = $request->all();
        $data["name"]       = $request->firstname;
        $data["fullname"]   = $request->firstname.' '.$request->lastname;

        if( (new Store)->create($data) )
        {
            return back();
        }
    }

    public function setState($user, $state) {
        
        if( request()->user()->id != $user->id ){
            $user->update(["activated" => $state]);
        }

        return back();
    }

    public function getUpdateCredential( $user )
    {
        $data["title"]  = __("update.credentials");
        $data["user"]   = $user;

        return $data;
    }
   
    public function postUpdateCredential( $user, $request )
    {
        $messages["required"] = __("validation.required");

        $attributes["firstname"]    = __("words.firstname");
        $attributes["lastname"]     = __("words.lastname");
        $attributes["name"]         = __("public.name");


        $request->validate([
            "firstname" => "required",
            "lastname"  => "required",
            "name"      => "required"
        ], $messages, $attributes);

        if( $user->update($request->all() ) ) {
            return redirect("admin/users");
        }

        return back();
    }

    public function getUpdatePassword($user){

        $data["title"] = __("update.password");
        $data["user"]   = $user;

        return $data;
    }

    public function postUpdatePassword($user, $request)
    {
        $request->validate([
            "password" => "required"
        ],[], [
            "password" => __("words.password")
        ]);

        $user->password = $request->password;

        if( $user->save() ) 
        {
            return redirect("admin/users");
        }

        return back();
    }
}