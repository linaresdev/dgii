<?php
namespace DGII\Http\Support\Admin\Entity;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

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

    public function postEntityRegister( $request ) {

        $YDate = now()->format('Y');
        $V = $request->validatorInstance();

        if( openssl_pkcs12_read($request->getCertifyContent(), $data, $request->pwd) )
        {
            $certify = new P12Certify( $data );

            $fields["name"]         = $request->name;
            $fields["email"]        = $certify->email();
            $fields["slug"]         = $certify->user();
            $fields["certify"]      = $certify->fileName();
            $fields["password"]     = $request->pwd;
            
            $ruls["email"]          = "required|unique:users,email";
            $ruls["slug"]           = "required|unique:users,user";
            $ruls["password"]       = "required";

            $msg["email"]   = __("validation.has.entity");
            $msg["slug"]    = __("validation.slug.entity");

            if(($check = validator($fields, $ruls, $msg))->fails())
            {
                return back()->withErrors($check)->withInput(); 
            }

            if( (new Hacienda)->has($certify->user()) ) {

                $account                = $fields;
                $account["user"]        = $certify->user();
                $account["type"]        = "entity";
                $account["activated"]   = 1;

                if( ($user = (new User)->create($account)) )
                {
                    $directory = __path("{hacienda}/".$user->user."/$YDate/".env("DGII_ENV"));

                    if( (new Hacienda)->create($fields) ) {
                        ## Creamos directorios base
                        if( !app('files')->exists($directory) ) {
                            app("files")->makeDirectory($directory, 0750, true);
                        }

                        ## Movemos el certificado a su directorio
                        $request->moveCertify(__path("{hacienda}/".$user->user), 'certify.p12');
                    }
                    
                    return redirect("admin/entities");
                }
            }

            $V->errors()->add("certify", "Error al tratar de registrar la entidad");
            return back()->withErrors($V)->withInput(); 
        }

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
}