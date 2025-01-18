<?php
namespace DGII\Http\Controllers\Entity;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

use DGII\Http\Support\Entity\Home;

class HomeController extends Controller {

    public function __construct( Home $app ) {
        $this->boot($app);
    }

    public function index() {
        
        return $this->render('index', $this->app->index());
    }
}