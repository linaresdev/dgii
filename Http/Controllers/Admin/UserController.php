<?php
namespace DGII\Http\Controllers\Admin;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

use Illuminate\Http\Request;
use DGII\Http\Support\Admin\UserSupport;
use DGII\Http\Request\Admin\UserRegisterRequest;

class UserController extends Controller {

    protected $path = "dgii::admin.users.";

    public function __construct( UserSupport $app )
    {
        $this->boot($app);
    }

    public function index()
    {
        return $this->render('index', $this->app->index());
    }

    public function getRegister()
    {
        return $this->render('register', $this->app->getRegister());
    }

    public function postRegister( UserRegisterRequest $request )
    {
        return $this->app->postRegister($request);
    }

    public function setState($user, $state)
    {
        return $this->app->setState($user, $state);
    }

    ## Mantanance
    public function getUpdateCredential($user) {
        return $this->render(
            "update.credential", $this->app->getUpdateCredential($user)
        );
    }

    public function postUpdateCredential( $user, Request $request )
    {
        return $this->app->postUpdateCredential( $user, $request );
    }

    public function getUpdatePassword( $user ){
        return $this->render(
            "update.password", $this->app->getUpdatePassword($user)
        );
    }
    public function postUpdatePassword( $user, Request $request ){
        return $this->app->postUpdatePassword($user, $request);
    }
}