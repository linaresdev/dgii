<?php
namespace DGII\Http\Controllers;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/


use DGII\Http\Support\Auth;
use Illuminate\Http\Request;
use DGII\Http\Request\AuthRequest;
use DGII\Http\Request\LoginRequest;

class AuthController extends Controller {

    public function __construct( Auth $app ) {
        $this->boot($app);
    }

    public function getWebLogin() {
        return $this->render('login', $this->app->webLogin());
    }

    public function postWebLogin( LoginRequest $request ) {
        return $this->app->guestLogin($request);
    }

    public function getWebLogout(){
        return $this->app->webLogout(auth("web"));
    }

    public function getWebAuth() {
        return $this->render('auth', $this->app->webLogin());
    }
    public function postWebAuth(AuthRequest $request) {
        return $this->app->geuestAuth($request);
    }

    public function getSeed( $ent ) {
        return $this->app->getSeed($ent);
    }

    public function guestAuth( Request $request) {
        return $this->app->guestAuth($request);
    }

    public function noLogin()
    {
        return response()->json("Autenticacion requerida", 401);
    }
}