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
    public function __construct( EntitySupport $app )
    {
        $this->boot($app);
    }

    public function index($entity) 
    { 
        return $this->render('entity.index', $this->app->index($entity));
    }

    public function srcEcf( $entity, $src )
    {
        return $this->render("entity.search", $this->app->search($entity, $src));
    }

    public function downloadEcf($entity, $ecf)
    {
        return $this->app->downloadEcf($entity, $ecf);
    }

    public function setConfig( $entity, $key, $value )
    {
        return $this->app->setConfig($entity, $key, $value);        
    }

    public function arecf($entity, $ecf)
    { 
        return $this->render("entity.arecf", $this->app->arecf($entity, $ecf));
    }

    public function downloadArecf($entity, $ecf)
    {
        return $this->app->downloadArecf($entity, $ecf);
    }

    public function acecf($entity, $ecf)
    { 
        return $this->render("entity.acecf", $this->app->acecf($entity, $ecf));
    }
    
    public function downloadAcecf($entity, $ecf)
    {
        return $this->app->downloadAcecf($entity, $ecf);
    }
    public function getSendMailAcecf( $entity, $ecf )
    {
        return $this->render("entity.sendmail-acecf", $this->app->sendMailArecf($entity, $ecf));
    }
    public function postSendMailAcecf( $entity, $ecf, Request $request )
    {
        return $this->app->postSendMailArecf($entity, $ecf, $request);
    }

    public function getSendACECF( $entity, $ecf )
    {
        return $this->render('entity.sendArecf', $this->app->sendAprobacionComercial($entity, $ecf));
    }

    public function postSendACECF( $entity, $ecf, Request $request )
    {
        return $this->app->sendACECF( $entity, $ecf, $request );
    }
}