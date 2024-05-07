<?php
namespace DGII\Http\Controllers;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use Illuminate\Http\Request;
use DGII\Http\Support\ConsultaRecibo;

class ConsultaReciboController extends Controller {

    public function __construct( ConsultaRecibo $app ) {
        $this->boot($app);
    }

    public function index( $ent, Request $request ) 
    {
        return $this->app->consultaRecibo($ent, $request);
    }
}