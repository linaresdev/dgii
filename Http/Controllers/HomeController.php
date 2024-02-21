<?php
namespace DGII\Http\Controllers;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use DGII\Http\Support\Home;

class HomeController extends Controller {

    public function __construct( Home $app ) {
        $this->boot($app);
    }

    public function index() {
        return $this->render('home', $this->app->data());
    }
}