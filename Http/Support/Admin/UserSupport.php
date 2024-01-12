<?php
namespace DGII\Http\Support\Admin;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

use DGII\User\Model\Store;

class UserSupport
{
    protected $user;

    public function __construct(Store $user) {
        $this->user = $user;
    }

    public function index()
    {
        $data['title'] = __("words.accounts-users");
        $data["users"]  = $this->user->paginate(6);

        return $data;
    }
}