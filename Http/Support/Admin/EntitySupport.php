<?php
namespace DGII\Http\Support\Admin;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

use DGII\Model\Term;
use DGII\Facade\Dgii;
use DGII\Facade\Alert;
use DGII\Support\Guard;
use DGII\Model\Hacienda;
use DGII\Support\P12Certify;
use DGII\User\Model\Store as User;
use DGII\Write\Facade\Signer;

use DGII\User\Model\UserStack;

class EntitySupport {

    public function home() 
    {
        $user = request()->user();       

        $data['icon']   = '<span class="mdi mdi-bank"></span>';
        $data['title']  = __("words.entities");

        $data['entities'] = $this->getEntities(5);

        return $data;
    }

    public function show($entity)
    { 
        $data["title"]      = $entity->name;
        $data["entity"]     = $entity;
        
        return $data;
    }

    public function setEnv($entity, $request)
    {
        if( ($env = env("DGII_ENV")) != ($inp = $request->env) )
        {
            $oldEnv = "DGII_ENV=$env";
            $newEnv = "DGII_ENV=$inp";
            $envData = app("files")->get(base_path('.env'));
            $envData = str_replace($oldEnv, $newEnv, $envData);

           app("files")->put(base_path('.env'), $envData);
        }
        
        return back();
    }

    public function getEntities($perpage)
    {
        return (new Hacienda)->paginate($perpage);
    }

    public function postEntityRegister( $request )
    {         

        if( !$request->user()->can("insert", "admin") ) {
           return $request->news("rol", __("auth.rol.deny"));
        }         
        
        if( openssl_pkcs12_read($request->getCertifyContent(), $data, $request->pwd) )
        { 
            if( ( $cert = (new P12Certify($data)) )->passes() ) 
            { 
                if( ($validate = $cert->dataValidate($request))->passes() )
                {                    
                    
                    if( ($entity = (new Hacienda)->create($cert->getData($request))) )
                    {
                        ## PREPARE SLUG ENTITY
                        $entity->makeUniqueSlug();

                        # Make resources
                        if( $cert->makeResources($request, $entity) ) {    

                            if((new Term)->create($cert->workGroup(($entity))))
                            {
                                Alert::prefix("system")->success(__("insert.successfully"));
                                return redirect('admin/entities');
                            }                        
                        }
                    }

                    $validate->errors()->add("certify", __("validation.entity.resources"));
                }                
            }

            //$validate->errors()->add("certify", "No se pudo comprobar la integridad delcertificado"); 
            
            return back()->withErrors($validate)->withInput(); 
        }
       // dd(openssl_error_string());
        $V = validator([],[]);
        $V->errors()->add("certify", __("validation.bad.certify"));
        return back()->withErrors($V)->withInput();
    }



    public function entity($ent)
    {
        $data['icon']   = '<span class="mdi mdi-bank"></span>';
        $data["title"]  = $ent->name;
        $data["entity"] = $ent;

        return $data;
    }

    public function postUpdateName($ent, $request)
    {
        if( !$request->user()->can("update", "admin") ) {
            $V = validator([],[]);
            $V->errors()->add("rol", __("auth.rol.deny"));
            return back()->withErrors($V)->withInput();
        }

        $request->validate([
            "name" => "required|min:12"
        ]);

        if( $ent->update($request->except("_token")) ) {
            Alert::prefix("update")->success(__("update.successfully"));
        }
        else{
            Alert::prefix("update")->danger(__("update.error"));
        }

        return back();
    }

    public function postUpdateCertify($ent, $request)
    {        

        $validate = validator([], []);

        if( openssl_pkcs12_read($request->getCertifyContent(), $data, $request->pwd) )
        { 
            if( ( $cert = (new P12Certify($data)) )->passes() ) 
            { 

                $update = $ent->update([
                    "p12" => $request->getCertifyContent(), 
                    "password" => $request->pwd
                ]);

                if( $update ) {

                    $request->moveCertify(__path("{hacienda}/".$ent->rnc), 'certify.p12');

                    Alert::prefix("system")->success(__("update.successfully"));

                    return redirect('admin/entities');
                }                           
            }

            $validate->errors()->add("certify", "No se pudo comprobar la integridad delcertificado"); 
            
            return back()->withErrors($validate)->withInput(); 
        }
    }

    public function setState( $ent, $state ) {
       
        if( in_array($state, [0,1,2,3,4]) ) {
            $ent->update(["activated" => $state]);
        }

        return back();
    }

    public function delete($ent, $request)
    {
        if( !$request->user()->can("delete", "admin") )
        {
            $alert = Alert::addErrors(
                "danger", __("auth.rol.deny")
            );
            return back()->withErrors($alert)->withInput();
        }       

        $attributes["name"]      = __("business.name");
        $attributes["delegate"]  = __("business.delegate");

        

        $request->validate([
            "name"      => "required",
            "delegate"  => "required"
        ], [], $attributes);       

        if( $ent->name == $request->name )
        {
            (new Term)->deleteTax("user-group", $ent->rnc);     
            $ent->delete();

            Alert::prefix("system")->success(__("delete.successfully"));
            return redirect("admin/entities");
        }
        
        ($validate = validator([],[]))->errors()->add("entity", "Error credenciales");
        return back()->withErrors($validate)->withInput();        
    }

    ## USERS GROUPS
    public function getUsers( $ent )
    {

        $data['icon']   = '<span class="mdi mdi-bank"></span>';
        $data["title"]  = $ent->name;
        $data["ent"]    = $ent;
        $data["term"]   = $ent->group;
        $data["termID"] = $data["term"]->id;

        $data["urlAjax"] = __url('{entity}/'.$ent->id.'/users/sources');
       
        return $data;
    }

    public function getSourcesUsers($ent, $source) {

        $users = (new User)->where("fullname", 'LIKE', '%'.$source.'%');

        $data["users"]  = $users->get()->take(6);
        $data["uri"]    = "admin/entities/".__segment(3)."/users/add-group"  ;
        $data["termID"] = $ent->getTermID();

        return $data;
    }

    public function postAddUserEntity($ent, $request )
    {
        $termID = $request->termID;
        $userID = $request->ID;
        $rols   = $request->except(["_token", "termID", "ID"]);

        if( (($user = (new User)->find($userID) ?? null ) != null ) ) 
        {
            $user->syncGroup( $termID, $rols );
        }

        return back();
    }

    public function removeUserFromEntity( $user, $termID ) 
    {
        $user->groups()->detach($termID);
        return back();
    }

    ## SHOW ECF
    public function getECF($ent)
    {
        $data["title"]      = $ent->name;
        $data["entity"]     = $ent;

        $data["arecf"]      = $this->getPaginateArecf($ent);

        Dgii::addUrl([
            "{ecf}" => "{entity}/show/$ent->id/ecf",
        ]);

        return $data;
    }

    public function getInfoECF($ent, $info)
    {
        $data["title"]      = $ent->name;
        $data["entity"]     = $ent;

        $data["ecf"]        = $info;
        $data["data"]       = $info->pathECF;
        $data["items"]       = $info->pathECF->getItems();

        Dgii::addUrl([
            "{ecf}" => "{entity}/show/$ent->id/ecf",
        ]);
        
        return $data;
    }

    public function getPaginateArecf($ent, $perpage=10) {
        $data = $ent->arecf();
        return $data->orderBy("id", "DESC")->paginate($perpage);
    }

    public function getEcfDownload( $path ) {
        return response()->download($path);
    }
}