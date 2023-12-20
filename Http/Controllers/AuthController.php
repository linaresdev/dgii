<?php
namespace DGII\Http\Controllers;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

use DGII\Http\Support\Auth;

class AuthController extends Controller {

    public function __construct( Auth $app ) {
        $this->boot($app);
    }

    public function getSeed() {
        return $this->app->getSeed();
    }
}