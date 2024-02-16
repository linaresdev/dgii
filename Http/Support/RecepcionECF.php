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

        $this->arecf["path"] = $ecf->get("path");
        $this->arecf["FechaHoraAcuseRecibo"] = ($date = now()->format("d-m-Y H:m:s"));
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

            if( !app("files")->exists(($PATHARECF = __path("{ARECF}"))) )
            {
                app("files")->makeDirectory($PATHARECF, 0775, true);
            } 

            $ecf->add("path", "$PATHARECF/$fileName");

            ## VALIDA CODE 1
            ## Error de especificación
            if( $ecf->validate()->errors()->any() )
            { 
                
                $XML = $this->xmlARECF($ecf, 1, 1);
                $XML = Signer::from($ent)->before('</ARECF>', $XML);

                return response($XML, 400, [
                    'Content-Type' => 'application/xml'
                ]);
            }

            ## VALIDA CODE 2
            ## Error de Firma Digital                
            if( $ecf->checkSignature()->errors()->any() )
            {
                $XML = $this->xmlARECF($ecf, 0, 2);
                $XML = Signer::from($ent)->before('</ARECF>', $XML);

                //app("files")->put($PATHARECF.'/'.$fileName, $XML);
                return response($XML, 400, [
                    'Content-Type' => 'application/xml'
                ]);
            }

            ## VALIDA CODE 3
            ## Envío duplicado
            if( $ecf->exists()->errors()->any() )
            {
                $XML = $this->xmlARECF($ecf, 1, 3);
                $XML = Signer::from($ent)->before('</ARECF>', $XML);                
                //app("files")->put($PATHARECF.'/'.$fileName, $XML);

                return response($XML, 400, [
                    'Content-Type' => 'application/xml'
                ]);
            }           

            ## VALIDA CODE 4
            ## RNC Comprador no corresponde
            if( $ecf->checkRNCComprador()->errors()->any() )
            {
                $XML = $this->xmlARECF($ecf, 0, 4);
                $XML = Signer::from($ent)->before('</ARECF>', $XML);

                return response($XML, 400, [
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
                $ARECF  = $this->xmlARECF($ecf, 0); 
               
                $ent->saveARECF($this->arecf);

                $signer = Signer::from($ent)->before('</ARECF>', $ARECF);                

                app("files")->put($PATHARECF.'/'.$fileName, $signer);

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