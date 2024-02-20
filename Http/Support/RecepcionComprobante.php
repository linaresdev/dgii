<?php
namespace DGII\Http\Support;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use Illuminate\Validation\Rule;
use DGII\Model\AprobacionComercial;
use DGII\Http\Support\Recepcion\AprobacionData;

class RecepcionComprobante {

    public function errorMessage($message) {
        $stub = '<?xml version="1.0" encoding="UTF-8"?>
        <AprobacionComercial>
            <Mensaje>{Mensaje}</Mensaje>
        </AprobacionComercial>';

        $xml = str_replace('{Mensaje}', $message, $stub);

        $dom = new \DOMDocument;

        $dom->preserveWhiteSpace    = false;
        $dom->formatOutput          = true;

        $dom->loadXML($xml);

        return $dom->saveXML();
    }

    public function recepcionComprobante($request)
    {             
        if( $request->hasFile("xml") )
        {      
            $xmlData = (new AprobacionData($request->file("xml")));     
            $entity = $xmlData->entity();

            if( !$xmlData->hasEntity() )
            {
                return response($this->errorMessage("Insastifactorio"), 400, [
                    'Content-Type' => 'application/xml'
                ]);
            }

            $data["Estado"]                         = 1;
            
            $ruls["Version"] 						= "required";
            $ruls["RNCEmisor"] 						= ["required", new \DGII\Rules\RNC];
            $ruls["eNCF"] 							= ["required","unique:\DGII\Model\AprobacionComercial,eNCF", new \DGII\Rules\Encf];
            $ruls["FechaEmision"] 					= "required";
            $ruls["MontoTotal"] 					= "required|numeric";
            $ruls["RNCComprador"] 					= "required";
            $ruls["Estado"] 						= ["required",Rule::in([1,2])];
            $ruls["DetalleMotivoRechazo"] 			= "";			
            $ruls["FechaHoraAprobacionComercial"] 	= "";

            $messages["unique"] = __("validate.unique");
            $attrs["eNCF"] = "comprobante";
        
            $validate = validator($xmlData->all(), $ruls, $messages, $attrs);

            if( ($errors = $validate->errors())->any() )
            {          
                return response(null, 400);
            }

            $xml        = $request->file("xml");
            $fileName   = $xmlData->get("RNCComprador").$xmlData->get("eNCF").".xml";
            
            if( !app("files")->exists(($path = __path("{AprobacionComercial}"))) )
            {
                app("files")->makeDirectory($path, 0775, true);
            }           
        
            if( $xml->move($path, $fileName) ) 
            {
                $storData               = $xmlData->all();
                $storData["filename"]   = $fileName;
                $storData["path"]       = "$path/$fileName";
                $storData["state"]      = $xmlData->get("Estado");

                if($entity->saveAprobacionComercial($storData))
                {
                    return response(null, 200);
                }                
            }

            return response( $this->errorMessage("Insastifactorio"), 400, [
                'Content-Type' => 'application/xml'
            ]);            
        }

        return response(null, 400);        
    }
}