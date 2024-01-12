<?php
namespace DGII\Http\Controllers\Admin;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

use DGII\Http\Support\Admin\UserGroupSupport;

class UserGroupController extends Controller
{
    protected $path = "dgii::admin.users.groups.";
    
    public function __construct( UserGroupSupport $app ) {
        $this->boot($app);
    }

    public function index() {
        return $this->render('index', $this->app->index());
    }
}