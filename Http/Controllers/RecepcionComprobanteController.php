<?php
namespace DGII\Http\Controllers;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

use Illuminate\Http\Request;
use DGII\Http\Support\RecepcionComprobante;

class RecepcionComprobanteController extends Controller {

    public function __construct( RecepcionComprobante $support ) {
        $this->boot($support);
    }

    public function index( Request $request ) {
        return $this->app->recepcionComprobante($request);
    }
}