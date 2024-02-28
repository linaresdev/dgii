<?php
namespace DGII\Http\Support\Entity;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

use DGII\Facade\Dgii;
use DGII\Facade\XLib;
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

        // $data[3][0]["label"] = "CUENTA :";
        // $data[3][0]["value"] = "";
        // $data[3][1]["label"] = "#ORDEN :";
        // $data[3][1]["value"] = "";
    }

    public function totales()
    {
        $data[0]["label"] = "VALOR GRAVADO RD$";
        $data[0]["value"] = "MontoGravadoTotal";

        // $data[1]["label"] = "DESCUENTO RD$";
        // $data[1]["value"] = "DescuentoMonto";

        // $data[2]["label"] = "DESC. DEDUCIBLE RD$";
        // $data[2]["value"] = "";

        // $data[3]["label"] = "SUB-TOTAL RD$";
        // $data[3]["value"] = "DescuentoMonto";

        $data[4]["label"] = "ITBIS RD$";
        $data[4]["value"] = "TotalITBIS";
        
        // $data[5]["label"] = "OTROS IMPUESTOS RD$";
        // $data[5]["value"] = "";

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

    public function index($entity) {

        $data               = $this->header($entity);
        $data["arecf"]      = $entity->arecf->take(10);

        //dd($entity->arecf[0]->pathECF);
        return $data;
    }

    public function arecf($entity, $ecf)
    {
        $data        = $this->header($entity, $ecf);        
        $data["ecf"] = $ecf;

        $data["headerFields"]   = $this->ecfFieldHeader();
        $data["totales"]        = $this->totales();

        //dd($ecf->pathECF);
        return $data;
    }

    public function sendARECF($entity, $ecf, $request)
    {
        ## Solicitar Semilla
        $xmlSeed = Http::get(
            "https://ecf.dgii.gov.do/testecf/emisorreceptor/fe/autenticacion/api/semilla"
        )->body();
        
        ## Firmar Semilla
        $seedSigner = XLib::load($entity)->xml($xmlSeed)->sign();
        
        ## Solicitar Token
        $urlAuth = "https://ecf.dgii.gov.do/testecf/emisorreceptor/fe/autenticacion/a
        pi/validacioncertificado";

        $auth = Http::attach(
            'xml', $seedSigner, "Certify.xml", ["Content-Type" => "text/xml"])->post(
            "https://ecf.dgii.gov.do/testecf/emisorreceptor/fe/autenticacion/api/validacioncertificado"
        )->body();
        $auth = json_decode($auth);

        $url    = "https://ecf.dgii.gov.do/ecf/consultadirectorio/api/consultas/obtenerdirectorioporrnc?RNC";
        $url = "$url=".$ecf->item("RNCComprador");
       
        $remoteData = Http::withToken($auth->token)->acceptJson()->get($url)->body();
        dd($remoteData);

        return back();
    }
}