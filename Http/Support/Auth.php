<?php
namespace DGII\Http\Support;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use DGII\Facade\Alert;
use DGII\User\Model\Store;
use DGII\Write\Facade\Signer;
use DGII\Write\Facade\XmlSeed;
use DGII\Write\Support\XmlRead;

use DGII\Facade\Hacienda;

class Auth
{
    public function webLogin()
    {
        $data["title"] = __("words.authentication");
        return $data;
    }

    public function guestLogin($request)
    {
        $validator   = validator([],[]);
        
        if( ($guard = auth("web"))->attempt($request->except('_token')) ) 
        {
            $user = $guard->user();
            
            for( $i=-0; $i<5; $i++) {
                if( ($i != 1) && $user->activated == $i )
                {
                    $user->news("login", __("words.rejected"), [
                        "message" => __("account.$i")
                    ]);

                    $guard->logout();
                    $validator->errors()->add('login', __("account.$i"));
                    return back()->withErrors($validator)->withInput();
                }
            }
            
            if( $user->activated > 4 )
            {
                $user->news("login", "words.rejected", [
                    "message"   => __("access.fishy").', '. __("account.".$user->activated)            
                ]);

                $guard->logout();

                $validator->errors()->add('login', __("auth.bad"));
                return back()->withErrors($validator)->withInput();
            }
            
            $user->news("login", "words.aprobed");
            return redirect("admin");
        }

        $validator->errors()->add('login', __("auth.bad"));

        return back()->withErrors($validator)->withInput();
    }

    public function webLogout($auth)
    {
        $auth->user()->news("logout", "words.approved", [
            "message" => "auth.logout"
        ]);

        $auth->logout();       
        
        return redirect("login");
    }

    public function verifyXmlSchema($xml, $xsd)
    {
        if( !empty($xml) && !empty($xsd) )
        {
            @($dom = new \DOMDocument())->loadXML($xml);
            return ($this->verifySchema = @$dom->schemaValidate($xsd));
        }

        return $this->verifySchema;
    }

    public function getUserOld($x509=null)
    {
        return (new Store)->where("pem", $x509)->first() ?? null;
    }

    public function formatXml($stub)
    {
        $dom = new \DOMDocument;

        $dom->preserveWhiteSpace    = false;
        $dom->formatOutput          = true;

        $dom->loadXML($stub);

        return $dom->saveXML();
    }

    public function guestAuth($request)
    {
        $stub = '<?xml version="1.0" encoding="UTF-8"?>
        <RespuestaAutenticacion>
            <token>{token}</token>
            <expira>{expira}</expira>
            <expedido>{expedido}</expedido>
        </RespuestaAutenticacion>';

        if( $request->hasFile("xml") )
        {
            $xmlContent = $request->file("xml")->getContent();
            $xsd        = __path('{wvalidate}/Seed.xsd');

            if( !$this->verifyXmlSchema($xmlContent, $xsd) )
            {
                return response()->json([
                    "messaje" => "El XML contiene errores",
                    "errores"   => [
                        "Verifique la estructura del archivo"
                    ]
                ]);
            }            
            
            if( ($xmlObj = new XmlRead($xmlContent))->has() ) 
            {
                if( now()->create($xmlObj->date())->diffInMinutes() > 120 )
                {
                    return response("Esta solicitud expiró");
                }

                if( (new Store)->personalToken(hash('sha256', $xmlObj->token())) != null )
                {
                    return response("Solicitud ocupada.");
                }

                $token      = $xmlObj->token();
                $stack      = $xmlObj->stack();
                $entity     = $xmlObj->entity();
                $userOld    = $this->getUserOld($xmlObj->getX509());
                $password   = md5($token);

                if( $userOld != null )
                {
                    $userOld->password = $password;
                    $userOld->save();
                    
                    $user = $userOld;
                }
                else
                {
                    $credential["type"]         = "SOAClient";
                    $credential["name"]         = "Anonimous";
                    $credential["password"]     = $password;
                    $credential["email"]        = \Str::random(mt_rand(7, 15))."@soaclient.lc";
                    $credential["pem"]          = $xmlObj->getX509();
                    $credential["activated"]    = 1;

                    if( $user = (new Store)->create($credential) )
                    {
                        if( $stack != null )
                        {
                            $stack->delete();
                        }
                        
                       // return $this->createSessionApi($stors, $xmlObj);
                    }
                }

                if( !auth()->attempt(["pem" => $user->pem, "password" => $password]))
                {   
                    return response()->json([
                        "message" => "Unauthorized"
                    ], 400); 
                }

                ## SETTINGS
                $request->user()->loadCustomToken($xmlObj->token());
                
                $token = ($instToken = $request->user()->createToken(
                    "DGII",
                    ['*'],
                    now()->addSeconds(62)
                ))->plainTextToken;

                $accessToken = $instToken->accessToken;
                
                $expira     = $accessToken->expires_at->toAtomString();
                $expedido   = $accessToken->created_at->toAtomString();
                
                $outXml = str_replace('{token}', $token, $stub);
                $outXml = str_replace('{expira}', $expira, $outXml);
                $outXml = str_replace('{expedido}', $expedido, $outXml);

                $outXml = $this->formatXml($outXml);
                
                return response($outXml, 200, [
                    'Content-Type' => 'application/xml'
                ]);
            }

            return response("Semilla no valida.");            
        }

        return response("Error XML");
    }
    

    public function getSeed($ent)
    { 
        return response(Hacienda::load($ent)->makeSeed(), 200, [
            'Content-Type' => 'application/xml'
        ]);

       // $xml = Hacienda::seedSigner($xmlSeed, '</SemillaModel>', true);

        // return null;
        // if($ent->activated != 1) {
        //     return response(__("account.{$ent->activated}"));
        // }

        // $seedXml = XmlSeed::stub();
        // $entity  = __segment(2);
        // // return response($seedXml, 200, [
        // //     'Content-Type' => 'application/xml'
        // // ]);

        // app("files")->put(__path("{hacienda}/$entity/SeedXml.xml"), $xml);

        // //return response($seedXml);
        
        // //dd($ent->password);
        // //$xml = XmlSeed::stub();
        
        // ## Simular Firma
        // if( Signer::entity($seedXml)->check() )
        // {
        //     $signer = Signer::method(OPENSSL_ALGO_SHA256)->sign();
        //     app("files")->put(__path("{hacienda}/$entity/Signer.xml"), $signer);
            
        //     dd((new XmlRead($signer))->flag());           
        // }
    }
}