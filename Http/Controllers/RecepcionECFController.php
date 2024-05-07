<?php
namespace DGII\Http\Controllers;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use Illuminate\Http\Request;
use DGII\Http\Support\RecepcionECF;

class RecepcionECFController extends Controller {

    public function __construct( RecepcionECF $support ) {
        $this->boot($support);
    }

    public function index($ent, Request $request) 
    {
        return $this->app->RecepcionECF($ent, $request);
    }
}