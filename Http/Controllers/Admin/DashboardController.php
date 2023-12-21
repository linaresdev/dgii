<?php
namespace DGII\Http\Controllers\Admin;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use DGII\Http\Support\Admin\Dashboard;

class DashboardController extends Controller {

    public function __construct( Dashboard $app ) {
        $this->boot($app);
    }

    public function index() {
        return $this->render('dashboard.index', $this->app->index());
    }
}