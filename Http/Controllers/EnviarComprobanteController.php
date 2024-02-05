<?php
namespace DGII\Http\Controllers;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use Illuminate\Http\Request;
use DGII\Http\Support\EnviarComprobante;

class EnviarComprobanteController extends Controller {

    public function __construct( EnviarComprobante $app ) {
        $this->boot($app);
    }

    public function index(Request $request) {
        return $this->app->enviarComprobante($request);
    }
}