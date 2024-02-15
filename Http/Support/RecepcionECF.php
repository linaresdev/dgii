<?php
namespace DGII\Http\Support;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use DGII\Facade\ECF;
use DGII\Model\Hacienda;
use DGII\Write\Facade\Signer;
use Illuminate\Validation\Rule;

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

        if($state == 1)
        {
            $this->arecf["Estado"] = $state;

            $stub = str_replace(
                "<CodigoMotivoNoRecibido>{CodigoMotivoNoRecibido}</CodigoMotivoNoRecibido>\n", null, $stub
            );
        }
        else{
            $stub = str_replace('{CodigoMotivoNoRecibido}', $code, $stub);
        }
        $this->arecf["path"] = $ecf->get("path");
        $this->arecf["FechaHoraAcuseRecibo"] = ($date = now()->format("d-M-Y H:m:s"));
        $stub = str_replace('{FechaHoraAcuseRecibo}', $date, $stub);

        return $stub;
    }

    public function recepcionECF($ent, $request)
    {
        if( $request->hasFile("xml") )
        {
            $xmlData    = ($file = $request->file("xml"))->getContent();
            $xsd        = __path('{wvalidate}/RecepcionComercial.xsd');
            $ecf        = ECF::load($xmlData);

            $ecf->add("fileName", ($fileName = $file->getClientOriginalName()));
            $ecf->add("path", __path("{Recepcion}/$fileName"));

            ## VALIDA CODE 1
            ## Error de especificación
            if( $ecf->validate()->errors()->any() )
            { 
                return response($this->xmlARECF($ecf, 0, 1), 400, [
                    'Content-Type' => 'application/xml'
                ]);
            }

            ## VALIDA CODE 2
            ## Error de Firma Digital                
            if( $ecf->exists()->errors()->any() )
            {
                return response($this->xmlARECF($ecf, 0, 3), 400, [
                    'Content-Type' => 'application/xml'
                ]);
            }

            ## VALIDA CODE 3
            ## Envío duplicado
            if( $ecf->checkSignature()->errors()->any() )
            {
                return response($this->xmlARECF($ecf, 0, 3), 400, [
                    'Content-Type' => 'application/xml'
                ]);
            }           

            ## VALIDA CODE 4
            ## RNC Comprador no corresponde
            if( $ecf->checkRNCComprador()->errors()->any() )
            {
                return response($this->xmlARECF($ecf, 0, 4), 400, [
                    'Content-Type' => 'application/xml'
                ]);
            }

            ## DIRECTORY
            if( !app("files")->exists(($path = __path("{Recepcion}"))) )
            {
                app("files")->makeDirectory($path, 0775, true);
            } 

            ## SAVE && RESPONSE ARECF
            if( $file->move($path, $fileName) ) 
            {              
                $ARECF  = $this->xmlARECF($ecf, 1); 
               
                $ent->saveARECF($this->arecf);
                $signer = Signer::from($ent)->before('</ARECF>', $ARECF);

                return response($signer, 200, [
                    'Content-Type' => 'application/xml'
                ]);
            }                

            return response($this->xmlARECF($ecf, 0, 1), 400, [
                'Content-Type' => 'application/xml'
            ]);
        }
        

        $errors = $this->xmlNews([
            "Autenticacion requerida"
        ]);

        return response($errors, 400, [
            'Content-Type' => 'application/xml'
        ]);
    }
}