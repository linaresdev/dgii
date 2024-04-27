<?php
namespace DGII\Http\Support\Admin;

/*
 *---------------------------------------------------------
 * ©IIPEC
 * Santo Domingo República Dominicana.
 *---------------------------------------------------------
*/


class UserEntitySupport
{	
	protected $app;

	public function __construct()
	{
	}

	public function index()
    {
        $data['title'] 	= __("words.accounts-users");
        //$data["users"]  = $this->user->paginate(6);

        return $data;
    }
}

/* End of Controller UserEntitySupport.php */