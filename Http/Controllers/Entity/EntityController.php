<?php
namespace DGII\Http\Controllers\Entity;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/


use Illuminate\Http\Request;
use DGII\Http\Support\Entity\EntitySupport;

class EntityController extends Controller 
{
    public function __construct( EntitySupport $app ) {
        $this->boot($app);
    }

    public function index($entity) {
        return $this->render('entity.index', $this->app->index($entity));
    }

    public function ARECF($entity, $ecf)
    {
        return $this->render('entity.sendArecf', $this->app->arecf($entity, $ecf));
    }

    public function sendARECF($entity, $ecf, Request $request)
    {
        return $this->app->sendARECF($entity, $ecf, $request);
    }
}