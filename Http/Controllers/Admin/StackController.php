<?php
namespace DGII\Http\Controllers\Admin;

/*
 *---------------------------------------------------------
 * ©IIPEC
 * Santo Domingo República Dominicana.
 *---------------------------------------------------------
*/


use DGII\Facade\Alert;
use Illuminate\Http\Request;

use DGII\Http\Support\Admin\StackSupport;

class StackController extends Controller
{	
	public function __construct( StackSupport $app )
    {
        $this->boot($app);
        
        app("dgii")->addUrl([
            "{entity}" => "admin/entities"
        ]);        
    }

	public function index() {
        return $this->render('stacks.index', $this->app->index());
	}

    public function show( $stack ) {
        return $this->render(
            'stacks.show', $this->app->show($stack)
        );       
    }
}

/* End of Controller StackController.php */