<?php
namespace DGII\Http\Support\Entity;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

use DGII\Facade\Dgii;
use DGII\Facade\XLib;
use DGII\Facade\Alert;
use Illuminate\Support\Number;
use Illuminate\Support\Facades\Http;

class EntitySupport
{

    public function __construc()
    {
        // Dgii::addUrl([
        //     "{ent}" => 
        // ]);
    }

    public function ecfFieldHeader()
    {
        $data[0][0]["label"] = "EMISOR :";
        $data[0][0]["value"] = "RazonSocialEmisor";
        $data[0][1]["label"] = "CEDULA/RNC :";
        $data[0][1]["value"] = "RNCEmisor";

        $data[1][0]["label"] = "INDICADOR MONTO GRAVADO :";
        $data[1][0]["value"] = "IndicadorMontoGravado";
        $data[1][1]["label"] = "TELEFONO :";
        $data[1][1]["value"] = "";

        $data[2][0]["label"] = "CIUDAD :";
        $data[2][0]["value"] = "";
        $data[2][1]["label"] = "VENTA A :";
        $data[2][1]["value"] = "";

        return $data;
    }

    public function totales()
    {
        $data[0]["label"] = "VALOR GRAVADO RD$";
        $data[0]["value"] = "MontoGravadoTotal";

        $data[4]["label"] = "ITBIS RD$";
        $data[4]["value"] = "TotalITBIS";

        $data[6]["label"] = "TOTAL RD$";
        $data[6]["value"] = "MontoTotal";

        return $data;
    }
    

    public function header($entity)
    {
        $data["icon"]       = '<span class="mdi mdi-bank"></span>';
        $data['title']      = $entity->name;
        $data["container"]  = "col-xl-8 offset-xl-2 col-lg-10 offset-lg-1";
        $data["entity"]     = $entity;

        Dgii::addUrl([
            "{ent}" => "entity/{$entity->rnc}",
        ]);

        return $data;
    }

    public function index($entity)
    { 
        $config             = $entity->getConfig();
        $data               = $this->header($entity);
        $data["arecf"]      = $this->getEcf($entity); //$entity->arecf->take(10);
       
        $data["getConfig"]  = (function($key) use ($config) 
        {
            if( array_key_exists($key, $config) )
            {
                return $config[$key];
            }
        });

        $data['isLists']    = (function($key) use ($config) 
        {
            if( array_key_exists("ecf.lists.by", $config) )
            {
                if( $config["ecf.lists.by"] == $key ) 
                {
                    return true;
                }
            }
            return false;
        });

        $data['isFilter']    = (function($key) use ($config) 
        {
            if( array_key_exists("ecf.filter.by", $config) )
            {
                if( $config["ecf.filter.by"] == $key ) 
                {
                    return true;
                }
            }
            return false;
        });

        return $data;
    }

    public function downloadEcf( $entity, $ecf )
    {
        return response()->download($ecf->getOriginalEcf());
    }

    public function getEcf($entity)
    {
        return $entity->arecf()->orderBY("id", "DESC")->paginate(1);
    }

    public function setConfig( $entity, $key, $value )
    {
        $entity->toggleConfig(str_replace('-', '.', $key), $value);

        return back();
    }

    public function arecf( $entity, $ecf )
    {
        $data           = $this->header($entity);
        $data["ecf"]    = $ecf;
        $data["arecf"]  = $ecf->arecf();

        return $data;
    }

    public function downloadArecf( $entity, $ecf )
    {
        return response()->download($ecf->pathARECF);
    }

    public function acecf($entity, $ecf)
    {
        $data               = $this->header($entity);
        $data["ecf"]        = $ecf;
        $data["acecf"]      = $ecf->acecf;

        return $data;
    }

    public function downloadAcecf( $entity, $ecf )
    {
        return response()->download($ecf->acecf->pathAcecf());
    }

    public function sendAprobacionComercial($entity, $ecf)
    {
        $data                   = $this->header($entity, $ecf);        
        $data["ecf"]            = $ecf;

        $data["headerFields"]   = $this->ecfFieldHeader();
        $data["totales"]        = $this->totales();        

        $data['subject']        = "Detalle Aprobación Comercial";
        $message                = null;        

        if( !empty(($acecf = $ecf->acecf)) )
        { 
            $data["acecf"] = $acecf;

            if( !empty(($acecfDataFile = $acecf->acecf) ) )
            {
                foreach( $acecfDataFile->arrayFormat() as $label => $value )
                {
                    $message .= "$label ".str_repeat("-", (50 - strlen($label)))." $value\n\r";
                }
            }
        }
        
        $data['message'] = $message;
        
        return $data;
    }

    public function sendMailArecf($entity, $ecf)
    {
        $data                   = $this->header($entity, $ecf);        
        $data["ecf"]            = $ecf;        

        $data['subject']    = "Detalle Aprobación Comercial";
        
        
        return $data;
    }

    public function postSendMailArecf($entity, $ecf, $request) 
    {   
        $ruls["email"]      = "required|email";
        $ruls["subject"]    = "required";

        $mail = \Mail::to($request->email)->send(
            new \DGII\Http\Emails\SendACECF($entity, $ecf, $ecf->acecf)
        );

        return back();
    }

    public function ecfData( $ecf, $estado, $razon )
    {
        $data['RNCEmisor']                    = $ecf->pathECF->get("RNCEmisor");
        $data['eNCF']                         = $ecf->pathECF->get("eNCF");
        $data['FechaEmision']                 = $ecf->pathECF->get("FechaEmision");
        $data['MontoTotal']                   = $ecf->pathECF->get("MontoTotal");
        $data['RNCComprador']                 = $ecf->pathECF->get("RNCComprador");
        $data['Estado']                       = $estado;

        if($estado == 2) { $data['DetalleMotivoRechazo'] = $razon; }

        $data['FechaHoraAprobacionComercial'] = now()->format("d-m-Y H:i:s");
        
        return $data;
    }

    public function getNameEcf( $path )
    {
        $data = explode('/', $path);
        return end($data);
    }

    public function sendACECF($entity, $ecf, $request)
    {
        $user       = $request->user();       
        $estado     = $request->Estado;
        $razon      = $request->DetalleMotivoRechazo;

        ## DIRECTORIOS Y RECURSOS
        if( !app("files")->exists(($PATHACECF = __path("{ACECF}"))) )
        {
            app("files")->makeDirectory($PATHACECF, 0775, true);
        } 

        $filePath   = "$PATHACECF/";
        $filePath  .= ($nameAcecf = $this->getNameEcf($ecf->getOriginalEcf()));
     
        $data           = $this->ecfData($ecf, $estado, $razon);
        $data["ecf"]    = $ecf->getOriginalEcf();  
        $data["expira"] = $ecf->created_at->diffInDays();

        ## Ruls
        $ruls['RNCEmisor']      = "required|isRnc";
        $ruls['eNCF']           = "required|encf";
        $ruls['FechaEmision']   = "required";
        $ruls['MontoTotal']     = "required";
        $ruls['RNCComprador']   = "required";
        $ruls['Estado']         = "required";
        $ruls["ecf"]            = "unique:ACECF,ecf";
        $ruls["expira"]         = (function($attr, $value, $fail) {
            if( $value >= 30 ) $fail(__("validate.ecf.expira"));
        });        
        
        if( $estado == "2" ) {
            $data['DetalleMotivoRechazo'] = $request->DetalleMotivoRechazo;
            $ruls['DetalleMotivoRechazo'] = "required|max:250";
        }   
        
        $ruls["FechaHoraAprobacionComercial"] = "required";    
        
        $messages["unique"] = __("validate.ecf.unique");

        $V = validator($data, $ruls, $messages);
        
        if( $V->errors()->any() )
        {
            return back()->withErrors($V)->withInput();
        }

        ## Signed ACECF
        if(($acecf = $this->getSignedAcecf($entity, $data)) == null )
        {
            Alert::prefix("acecf")->danger(
                "La plantilla de la aprobación comercial no existe"
            );
            return back();
        }         
        
        ## DGII AUTH
        if( ($dgiiAuth   = $this->getDgiiToken($entity)) == null )
        {
            Alert::prefix("acecf")->danger("Error al tratar de autenticar en la DGII");
            return back();
        } 

        $remoteData = Http::acceptJson()->withToken($dgiiAuth->token)->get(
            __path("{dgii_client_info}?RNC=".$ecf->item("RNCComprador"))
        );

        if( $remoteData->status() != 200 )
        {
            Alert::prefix("acecf")->danger("No fue posible acceder a la informaciones del cliente");
            return back();
        }

        $remoteData = json_decode($remoteData->body());

        if( array_key_exists(0, $remoteData) )
        {
            $clientData = (array) $remoteData[0];

            ## Nos autenticamos en el cliente si es requerido
            if( !empty($clientData["urlOpcional"]) )
            { 
                if( ($clientAuth = $this->getClientToken($entity, $clientData)) == null )
                {
                    Alert::prefix("acecf")->danger("Error al tratar de autenticar con el cliente");
                    return back();
                }

                ## Enviar la Aprobacion Comercial
                $clientUrlAcecf = $clientData['urlAceptacion'].'/'.env("DGII_RECEPCION_ARECF");
                $aprobacionComercial = Http::withToken($clientAuth->token)->attach(
                    'xml',$acecf, $nameAcecf, ["Content-Type" => "text/xml"]
                )->post(
                    $clientUrlAcecf
                );

                if($aprobacionComercial->status() == 200 )
                {
                    if(app("files")->put($filePath, $acecf) )
                    {
                        $acecfData          = (new \DGII\Support\ACECF)->load($filePath)->toArray();
                        $acecfData["ecf"]   = $ecf->getOriginalEcf();
                        $acecfData["acecf"] = $filePath;

                        if($acecfStore = $entity->saveACECF($acecfData))
                        {
                            Alert::prefix("system")->success(
                                "Aprobación comercial evianda correctamente"
                            );
                            $user->news("acecfSend", "Aprobación Comercial Enviada", [
                                "acecf_id"          => $acecfStore->id,
                                "path"              => request()->path(),
                                "urlSeed"           => $clientAuth->urlSeed,
                                "authUrl"           => $clientAuth->authUrl,
                                "cleintUrlAcecf"    => $clientUrlAcecf
                            ]);
                            
                            return redirect(__url("entity/{$entity->rnc}"));
                        }
                    }
                }
            }
            else {
                ## Enviar la Aprobacion Comercial
                $aprobacionComercial = Http::attach(
                    'xml',$acecf, $nameAcecf, ["Content-Type" => "text/xml"])->post(
                        $clientData['urlAceptacion'].'/'.env("DGII_RECEPCION_ARECF")
                );

                if($aprobacionComercial->status() == 200 )
                {
                    if(app("files")->put($filePath, $acecf) )
                    {
                        $acecfData          = (new \DGII\Support\ACECF)->load($filePath)->toArray();
                        $acecfData["ecf"]   = $ecf->getOriginalEcf();
                        $acecfData["acecf"] = $filePath;

                        $entity->saveACECF($acecfData);

                        Alert::prefix("system")->success(
                            "Aprobación comercial evianda correctamente"
                        );

                        $user->news("acecfSend", "Aprobación Comercial Enviada", [
                            "acecf_id"          => $acecfStore->id,
                            "path"              => request()->path(),
                            "urlSeed"           => null,
                            "authUrl"           => null,
                            "cleintUrlAcecf"    => $clientUrlAcecf
                        ]);
                        
                        return redirect(__url("entity/{$entity->rnc}"));
                    }
                }                
            }            
        }

        $user->news("acecfError", "Error Aprobación Comercial", [
            "rnc"       => $entity->rnc,
            "object"    => "Ocurrió un error al tratar de enviar la aprobación comercial"
        ]);

        Alert::prefix("system")->danger("Error al tratar de enviar la aprobación comercial");
        return back();
    }

    public function getSignedAcecf($entity, $data)
    {
        if( app("files")->exists(__path("{xmlstub}/ACECF.txt")) )
        {        
            $acecf      = app("files")->get(__path("{xmlstub}/ACECF.txt"));
            
            foreach( $data as $key =>  $value )
            {
                if( ($key == 'Estado') && ($value == 1) )
                {
                    $acecf  = str_replace(
                        '<DetalleMotivoRechazo>{DetalleMotivoRechazo}</DetalleMotivoRechazo>',"", $acecf
                    );
                }

                $acecf  = str_replace('{'.$key.'}', $value, $acecf);
            }

            return  XLib::load($entity)->xml($acecf)->sign();    
        }    
    }

    public function getClientToken($entity, $clientData)
    {
        $urlSeed = $clientData['urlOpcional'].'/'.env('DGII_CLIENT_SEED');

        if( ($clientSemilla = Http::get($urlSeed))->status() == 200 )
        {
            ## Firmar Semilla
            $signerClientSemilla = XLib::load($entity)->xml($clientSemilla->body())->sign();

            ## Solicitamos token
            $authUrl = $clientData['urlOpcional'].'/'.env("DGII_CLIENT_AUTH");
            $clientAuth = Http::attach(
                'xml', $signerClientSemilla, "Certify.xml", ["Content-Type" => "text/xml"])->post($authUrl);

            if( $clientAuth->status() == 200)
            {
                $data = json_decode($clientAuth->body());

                $data->urlSeed = $urlSeed;
                $data->authUrl = $authUrl;

                return $data;
            }            
        }        
    }

    public function getDgiiToken($entity)
    {
        ## Solicitar Semilla
        if( ($xmlSeed = Http::get(__path('{dgii_get_seed}')))->status() == 200  )
        {
            ## Firmar Semilla
            $seedSigner = XLib::load($entity)->xml($xmlSeed->body())->sign();        
            
            ## Solicitar Token         
            $auth = Http::attach(
                'xml', $seedSigner, "Certify.xml", ["Content-Type" => "text/xml"])->post(__path('{dgii_post_auth}')
            );

            if( $auth->status() == 200 )
            {
                return json_decode($auth->body());
            }    
        }         
    }
}