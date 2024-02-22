<?php
namespace DGII\Http\Controllers\Entity;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

use DGII\Http\Support\Entity\EntitySupport;

class EntityController extends Controller 
{
    public function __construct( EntitySupport $app ) {
        $this->boot($app);
    }

    public function index($entity) {
        return $this->render('entity.index', $this->app->index($entity));
    }
}