<?php
namespace DGII\Http\Controllers\Admin\Entity;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use DGII\Facade\Alert;
use Illuminate\Http\Request;
use DGII\Http\Support\Admin\EntitySupport;
use DGII\Http\Request\Admin\EntityRequest;
use DGII\Http\Request\Admin\UpdateCertifyRerquest;

class EntityController extends Controller {

    public function __construct( EntitySupport $app )
    {
        $this->boot($app);
        
        app("dgii")->addUrl([
            "{entity}" => "admin/entities"
        ]);        
    }

    public function index() 
    { 
        stack("Web-Requests", "Admin Entity", [
            "code"      => 200,
            "status"    => "Solicitud ",
            "path"      => request()->path()
        ]);

        return $this->render('home', $this->app->home());
    }

    public function show($entity)
    {
        return $this->render('show', $this->app->show($entity));
    }
    public function setEnv($entity, Request $request)
    {
        return $this->app->setEnv($entity, $request);
    }

    public function getEntityRegister() {
        return $this->render('register', $this->app->home());
    }

    public function postEntityRegister( EntityRequest $request ) {
        return $this->app->postEntityRegister($request);
    }

    public function getUpdateName($entity) {
        return $this->render("updateName", $this->app->entity($entity));        
    }
    public function postUpdateName($entity, Request $request) {  
        return $this->app->postUpdateName($entity, $request);      
    }

    public function getUpdateCertify($entity) {
        return $this->render("updateCertify", $this->app->entity($entity));        
    }
    public function postUpdateCertify($entity, UpdateCertifyRerquest $request) {  
        return $this->app->postUpdateCertify($entity, $request);      
    }

    public function setState($ent, $state) {
        return $this->app->setState($ent, $state);
    }

    public function getDelete($ent) {
        return $this->render("delete", $this->app->entity($ent));
    }

    public function postDelete($ent, Request $request ) {
        return $this->app->delete($ent, $request);
    }

    ## Users Support
    public function getUsers( $ent ) {
       return $this->render("users.home", $this->app->getUsers($ent));
    }

    public function getSourcesUsers($ent, $source ) {
        return $this->render(
            "users.sources", $this->app->getSourcesUsers($ent, $source)
        );
    }

    public function postAddUserEntity( $ent, Request $request ) {
        return $this->app->postAddUserEntity( $ent, $request );
    }

    public function getRemoveUserEntity( $ent, $user, $termID ) 
    {
        return $this->app->removeUserFromEntity( $user, $termID );
    }

    ## RECEPCION FACTURAS ECF
    public function getECF($ent) {
        return $this->render("ecf", $this->app->getECF($ent));
    }

    public function getInfoECF($ent, $info) {
        return $this->render("info", $this->app->getInfoECF($ent, $info));
    }

    public function getEcfDownload($ent, $store) {
        return $this->app->getEcfDownload($store->getOriginalEcf());
    }
}