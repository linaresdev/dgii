<?php
namespace DGII\Http\Controllers;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use Illuminate\Http\Request;
use DGII\Http\Support\EnviarAprobacionComercial;

class EnviarAprobacionComercialController extends Controller {

    public function __construct( EnviarAprobacionComercial $app ) {
        $this->boot($app);
    }

    public function index( $ent, Request $request ) {       
        return $this->app->enviarAprobacionComercial($ent, $request);
    }
}