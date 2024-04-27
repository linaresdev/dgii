<?php
namespace DGII\Support;
	
/*
 *---------------------------------------------------------
 * ©IIPEC
 * Santo Domingo República Dominicana.
 *---------------------------------------------------------
*/

use Illuminate\Http\Request;

class Flash
{	
	protected $app;

	protected $status;

	private static $METHODS = [
		"info",
		"error",
		"success",
		"warning",
	];

	public function __construct( Request $request )
	{	
		$this->riquest = $request;
	}

	public function notify( $view="dgii::flashes.noty" )
	{
		if( $this->request->session()->has("noty.status") )
		{
			
		}
	}

	public function __call($method, $arg)
	{
		if( in_array($method, self::$METHODS) )
        {
            $this->status 	= $method;
            $this->message 	= $arg;
        }
	}
}

/* End of Controller Flash.php */	