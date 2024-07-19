<?php
namespace DGII\Http\Support\Admin;

/*
 *---------------------------------------------------------
 * ©IIPEC
 * Santo Domingo República Dominicana.
 *---------------------------------------------------------
*/

use DGII\User\Model\UserStack;

class StackSupport
{	
	public function __construct()
	{	
	}

	public function index()
	{
		$data["title"] = __("words.security");

		$data["stacks"]	= $this->getAtacks( 10 );

		// stack("Web-Requests", $data["title"], [
        //     "code"      => 200,
        //     "status"    => "Solicitud ",
        //     "path"      => request()->path()
        // ]);

		return $data;
	}

	public function getAtacks($perpage=10) {
		$data  = (new UserStack)
			->orderBy("id", "DESC");

		return $data->paginate($perpage);
	}

	public function show( $stack )
	{
		$data["title"] = __("words.security");
		$data["stack"] = $stack;

		$data["container"] = "col-lg-6 offset-lg-3";

		return $data;
	}

}

/* End of Controller StackSupport.php */