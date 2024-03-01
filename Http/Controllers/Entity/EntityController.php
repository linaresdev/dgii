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

    public function arecf($entity)
    {
        return $this->render("entity.arecf", $this->app->arecf($entity));
    }

    public function acecf($entity)
    {
        return $this->render("entity.acecf", $this->app->acecf($entity));
    }

    public function getSendACECF($entity, $ecf)
    {
        return $this->render('entity.sendArecf', $this->app->sendArecf($entity, $ecf));
    }

    public function postSendACECF( $entity, $ecf, Request $request )
    {
        return $this->app->sendACECF( $entity, $ecf, $request );
    }
}