<?php
namespace DGII\Http\Controllers;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

use Illuminate\Http\Request;
use DGII\Http\Support\ConsultaRecibo;

class ConsultaReciboController extends Controller {

    public function __construct( ConsultaRecibo $app ) {
        $this->boot($app);
    }

    public function index( Request $request ) {
        return $this->app->consultaRecibo($request);
    }
}