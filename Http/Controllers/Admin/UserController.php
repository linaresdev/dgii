<?php
namespace DGII\Http\Controllers\Admin;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

use DGII\Http\Support\Admin\UserSupport;

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

    public function register()
    {
        return $this->render('register', $this->app->register());
    }
}