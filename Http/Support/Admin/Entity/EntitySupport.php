<?php
namespace DGII\Http\Support\Admin\Entity;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

use DGII\Model\Term;
use DGII\Model\Hacienda;
use DGII\Support\P12Certify;
use DGII\User\Model\Store as User;

class EntitySupport {

    public function home() {
        
        $data['icon']   = '<span class="mdi mdi-bank"></span>';
        $data['title']  = __("words.entities");

        $data['entities'] = $this->getEntities(5);

        return $data;
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
                    if( $cert->makeResources($request) ) {
                        $entity = (new Hacienda)->create($cert->getData($request));

                        ## CREAMOS EL GRUPO DE TRABAJO
                        if( ($group = (new Term)->create($cert->workGroup(($name = $request->name)))) )
                        { 
                            ## CREAMOS LA CUENTA DE LA ENTIDAD
                            if( ($user = (new User)->create($cert->accountData($name))) )
                            {
                                ## SYNC USER ENTITY 
                                $user->syncGroup($group, [
                                    "view"      => 1, 
                                    "insert"    => 1, 
                                    "update"    => 1, 
                                    "delete"    => 0,
                                ]);

                                ## SYNG ADMIN USER
                                $request->user()->syncGroup($group, [
                                    "view"      => 1, 
                                    "insert"    => 1, 
                                    "update"    => 1, 
                                    "delete"    => 1
                                ]);

                                return redirect('admin/entities');
                            }
                        }                        
                    }

                    $validate->errors()->add("certify", __("validation.entity.resources"));
                }

                //$validate->errors()->add("certify", "Error al tratar de registrar la entidad");
                return back()->withErrors($validate)->withInput(); 
            }
        }

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

    public function postUpdateName($ent, $request) {

        if( !$request->user()->can("update", "admin") ) {
            $V = validator([],[]);
            $V->errors()->add("rol", __("auth.rol.deny"));
           return back()->withErrors($V)->withInput();
        }

        $request->validate([
            "name" => "required|min:12"
        ]);

        if( $ent->update($request->except("_token")) ) {
            $ent->user->update($request->except("_token"));
        }

        return back();
    }

    public function setState( $ent, $state ) {
       
        if( in_array($state, [0,1,2,3,4]) ) {
            $ent->update(["activated" => $state]);
        }

        return back();
    }

    public function delete($ent, $request)
    {
        if( !$request->user()->can("delete", "admin") ) {
            $V = validator([],[]);
            $V->errors()->add("rol", __("auth.rol.deny"));
           return back()->withErrors($V)->withInput();
        }

        $attributes["name"]      = __("business.name");
        $attributes["delegate"]  = __("business.delegate");

        $validate = $request->validate([
            "name"      => "required",
            "delegate"  => "required"
        ], [], $attributes);        

        if( $ent->name == $request->name ) {
            (new Term)->where("type", "user-group")->where("slug", $ent->slug)->delete();
            $ent->user->delete();
            $ent->delete();

            return redirect("admin/entities");
        }

        $validate->errors()->add(__("business.name"), __("validate.bad.name"));
        return back()->withErrors($validate)->withInput(); 

        
    }
}