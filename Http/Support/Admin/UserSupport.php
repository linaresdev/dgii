<?php
namespace DGII\Http\Support\Admin;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

use DGII\Model\Term;
use DGII\Facade\Dgii;
use DGII\User\Model\Store;
use DGII\Button\Facade\Btn;

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

    public function register()
    {
        $data['title']      = __("register.users");
        $data["container"]  = "col-xl-6 offset-xl-3 col-lg-10 offset-md-1";
        
       

        return $data;
    }

   
}