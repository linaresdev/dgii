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
        
        $config =           $entity->getConfig();

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

    public function getEcf($entity)
    {
        return $entity->arecf()->orderBY("id", "DESC")->get()->take(10);
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
        $estado     = $request->Estado;
        $razon      = $request->DetalleMotivoRechazo;

        ## DIRECTORIOS Y RECURSOS
        if( !app("files")->exists(($PATHACECF = __path("{ACECF}"))) )
        {
            app("files")->makeDirectory($PATHACECF, 0775, true);
        } 

        $filePath   = "$PATHACECF/";
        $filePath  .= $this->getNameEcf($ecf->getOriginalEcf());
     
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
        
        //$baseUrl    = "http://192.168.10.18";

        $env        = env("DGII_ENV");
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
        
        ## Aprobacion Firmada
        $acecf = XLib::load($entity)->xml($acecf)->sign();        

        // if(app("files")->put($filePath, $acecf))
        // {
        //     $data["acecf"]  = $PATHACECF."/".$this->getNameEcf($ecf->getOriginalEcf());
            
        //     if( $entity->saveACECF($data) )
        //     {
        //         return redirect(__url('entity/'.$entity->rnc));
        //     }
        // }        

        ## Solicitar Semilla
        $xmlSeed = Http::get(
            "https://ecf.dgii.gov.do/$env/emisorreceptor/fe/autenticacion/api/semilla"
        )->body();
        dd($xmlSeed);
        ## Firmar Semilla
        $seedSigner = XLib::load($entity)->xml($xmlSeed)->sign();
        
        ## Solicitar Token
        $urlAuth = "https://ecf.dgii.gov.do/$env/emisorreceptor/fe/autenticacion/a
        pi/validacioncertificado";
        
        $auth = Http::attach(
            'xml', $seedSigner, "Certify.xml", ["Content-Type" => "text/xml"])->post(
            "https://ecf.dgii.gov.do/$env/emisorreceptor/fe/autenticacion/api/validacioncertificado"
        )->body();
        $auth = json_decode($auth);

        
        ## Enviar aprobacion a DGII
        $url = "https://ecf.dgii.gov.do/$env/consultadirectorio/api/consultas/obtenerdirectorioporrnc?RNC";
        $url = "$url=".$ecf->item("RNCComprador");
        $url = "$url=130329737";
       
        $remoteData = Http::acceptJson()->withToken($auth->token)->get($url)->body();
        $remoteData = json_decode($remoteData);
        
        dd($remoteData);

        ## Enviar Aprobacion Al Comprodor;

        //$urlAprobacion = 


        return back();
    }
}