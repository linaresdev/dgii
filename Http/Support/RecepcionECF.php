<?php
namespace DGII\Http\Support;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/
use DGII\Facade\ECF;
use DGII\Facade\XLib;
use DGII\Support\XML;
use DGII\Model\Hacienda;
use DGII\Write\Facade\Signer;
use Illuminate\Validation\Rule;

use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecurityKey;

class RecepcionECF 
{

    protected $data;

    protected $arecf;

    protected $errors;

    public function xmlNews($messages=[])
    {
        $stub   = app("files")->get(__path('{xmlstub}/messages.txt'));
        $stub   = str_replace('{Mensaje}', implode(',', $messages), $stub);

        $dom = new \DOMDocument;

        $dom->preserveWhiteSpace    = false;
        $dom->formatOutput          = true;

        $dom->loadXML($stub);

        return $dom->saveXML();
    }

    public function xmlARECF($ecf, $state=0, $code=0)
    {
        $stub = app("files")->get(__path("{xmlstub}/ARECF.txt"));

        $data = null;
        $srcs = [
            "RNCEmisor", 
            "RNCComprador", 
            "eNCF", 
            "Estado", 
            "CodigoMotivoNoRecibido"
        ];

        foreach( $srcs as $src )
        {
            if( !empty($ecf->get($src)) )
            {
                $this->arecf[$src] = $ecf->get($src);
                $stub = str_replace('{'.$src.'}',$ecf->get($src), $stub);
            }
        }

        $stub = str_replace('{Estado}', $state, $stub);

        if($state == 0)
        {
            $this->arecf["Estado"] = $state;

            $stub = str_replace(
                "<CodigoMotivoNoRecibido>{CodigoMotivoNoRecibido}</CodigoMotivoNoRecibido>", null, $stub
            );
        }
        else{
            $stub = str_replace('{CodigoMotivoNoRecibido}', $code, $stub);
        }

        $this->arecf["pathECF"] = $ecf->get("pathECF");
        $this->arecf["pathARECF"] = $ecf->get("pathARECF");
        $this->arecf["FechaHoraAcuseRecibo"] = ($date = now()->format("d-m-Y H:m:s"));
        $stub = str_replace('{FechaHoraAcuseRecibo}', $date, $stub);
        
        return $stub;
    }

    public function firmador($ent, $XML)
    { 
        $doc = new \DOMDocument("1.0", "utf-8");
        $doc->preserveWhiteSpace = false;
        $doc->formatOutput = true;
        $doc->loadXML( $XML );
        
        if( openssl_pkcs12_read($ent->p12, $data, $ent->password) )
        {
            $certify    = $data["cert"];
            $privatKey  = $data["pkey"];
            
            $objDSig = new XMLSecurityDSig(null);

            $objDSig->setCanonicalMethod(XMLSecurityDSig::EXC_C14N);

            $objDSig->addReference(
                $doc, 
                XMLSecurityDSig::SHA256, 
                array('http://www.w3.org/2000/09/xmldsig#enveloped-signature')
            );
            
            $objKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA256, array('type'=>'private'));

            $objKey->loadKey($privatKey, false);

            $objDSig->sign($objKey);

            $objDSig->add509Cert($certify);
            
            $objDSig->appendSignature($doc->documentElement);

            // $doc->save('./path/to/signed.xml');
            //dd($doc->documentElement->CN14());
            return $doc->saveXML();
        }
    }

    public function recepcionECF($ent, $request)
    {


        if( $request->hasFile("xml") )
        {
            $xmlData    = ($file = $request->file("xml"))->getContent();
            
            if( $file->clientExtension() != "xml" )
            { 
                $errors = $this->xmlNews([
                    "Documento no valido"
                ]);

                stack("Api-Requests", "Recepcion-$ent", [
                    "code"      => 400,
                    "status"    => "Documento no valido",
                    "path"      => $file->clientExtension()
                ]); 

                return response($errors, 400, [
                    'Content-Type' => 'application/xml'
                ]);
            }

            $xsd        = __path('{wvalidate}/RecepcionComercial.xsd');
            $ecf        = ECF::load($xmlData);

            $ent        = (new \DGII\Model\Hacienda)->where("rnc", $ent)->first() ?? abort(404);

            ## signer
            $fileName   = $ecf->get("RNCEmisor");
            $fileName  .= $ecf->get("eNCF").".xml";
            
            $ecf->add("fileName", $fileName);
            $ecf->add("pathECF", __path("{Recepcion}/$fileName"));

            if( !app("files")->exists(($PATHARECF = __path("{ARECF}"))) )
            {
                app("files")->makeDirectory($PATHARECF, 0775, true);
            } 

            $ecf->add("pathARECF", "$PATHARECF/$fileName");

            ## DIRECTORY
            if( !app("files")->exists(($path = __path("{Recepcion}"))) )
            {
                app("files")->makeDirectory($path, 0775, true);
            } 

            ## VALIDA CODE 3
            ## Envío duplicado
            if( $ecf->exists()->errors()->any() )
            {
                ## Estructura de respuesta no recibido
                $XML = $this->xmlARECF($ecf, 1, 3);
                
                $firma = XLib::load($ent)->xml($XML)->sign();
               
                //$firma = (new XML($ent))->xml($XML)->sign();               
                
                //$firma = $this->firmador($ent, $XML);
                
                ## Guardamos la factura
                $file->move($path, $fileName);

                //$firma = (new XML($ent))->xml($XML)->sign();
               // $firma = $xmlSigner->signXml($XML);
                app("files")->put( $PATHARECF.'/'.$fileName, $firma );

                stack("warning", "ECF : ".$ecf->get("eNCF"), [
                    "code"      => 3,
                    "status"    => "Envío duplicado",
                    "path"      => $PATHARECF.'/'.$fileName,
                ]);

                return response($firma, 400, [
                    'Content-Type' => 'application/xml'
                ]);
            } 

            ## VALIDA CODE 1
            ## Error de especificación
            if( $ecf->validate()->errors()->any() )
            {      
                $ecf->add("CodigoMotivoNoRecibido", 1);

                $XML    = $this->xmlARECF($ecf, 1, 1);
                //$firma  = $this->firmador($ent, $XML);
                $firma = XLib::load($ent)->xml($XML)->sign();

                ## Guardamos la factura
                if( $file->move($path, $fileName) )
                {
                    ## Creamos el archivo ARECF
                    app("files")->put($PATHARECF.'/'.$fileName, $firma);

                    ## REGISTRAMOS LOS RESULTADOS
                    $ent->saveARECF($this->arecf);
                }

                stack("error", "ECF : ".$ecf->get("eNCF"), [
                    "code"  => 1,
                    "status" => "Error de especificación",
                    "path"  => $PATHARECF.'/'.$fileName,
                ]);

                return response($firma, 400, [
                    'Content-Type' => 'application/xml'
                ]);
            }

            ## VALIDA CODE 2
            ## Error de Firma Digital                
            if( $ecf->checkSignature()->errors()->any() )
            {
                $XML = $this->xmlARECF($ecf, 0, 2);
                // $firma = $this->firmador($ent, $XML);
                $firma = XLib::load($ent)->xml($XML)->sign();             

                //app("files")->put($PATHARECF.'/'.$fileName, $XML);

                stack("error", "ECF : ".$ecf->get("eNCF"), [
                    "code"      => 2,
                    "status"    => "Error de Firma Digital"
                ]);

                return response($firma, 400, [
                    'Content-Type' => 'application/xml'
                ]);
            }                      

            ## VALIDA CODE 4
            ## RNC Comprador no corresponde
            if( $ecf->checkRNCComprador()->errors()->any() )
            {
                $ecf->add("CodigoMotivoNoRecibido", 4);

                $XML    = $this->xmlARECF($ecf, 1, 4);
                // $firma  = $this->firmador($ent, $XML);
                $firma = XLib::load($ent)->xml($XML)->sign();
                
                ## Guardamos la factura
                if( $file->move($path, $fileName) )
                {
                    ## Creamos el archivo ARECF
                    app("files")->put($PATHARECF.'/'.$fileName, $firma);

                    ## REGISTRAMOS LOS RESULTADOS
                    $ent->saveARECF($this->arecf);
                }

                stack("error", "ECF : ".$ecf->get("eNCF"), [
                    "code"      => 4,
                    "status"    => "Error de Firma Digital",
                    "path"      => $PATHARECF.'/'.$fileName,
                ]);

                return response($firma, 400, [
                    'Content-Type' => 'application/xml'
                ]);
            }            
            
            ## SAVE && RESPONSE ARECF
            if( $file->move($path, $fileName) ) 
            {              
                $XML  = $this->xmlARECF($ecf, 0); 
                app("files")->put($PATHARECF.'/Acuse.xml', $XML);
                
                $ent->saveARECF($this->arecf);

                //$firma = (new XML($ent))->xml($XML)->sign();
                // $firma = $this->firmador($ent, $XML);
                
                $firma = XLib::load($ent)->xml($XML)->sign();

                app("files")->put($PATHARECF.'/'.$fileName, $firma);

                return response($firma, 200, [
                    'Content-Type' => 'application/xml'
                ]);
            }                

            return response($this->xmlARECF($ecf, 0, 1), 400, [
                'Content-Type' => 'application/xml'
            ]);
        }               

        $errors = $this->xmlNews([
            "Ups!"
        ]);

        stack("Api-Requests", "Recepcion-$ent", [
            "code"      => 400,
            "status"    => "No existe un documento xml",
            "path"      => $errors
        ]); 

        return response($errors, 400, [
            'Content-Type' => 'application/xml'
        ]);
    }
}