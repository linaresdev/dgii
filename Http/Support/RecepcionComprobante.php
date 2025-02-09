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

    public function recepcionComprobante( $ent, $request )
    {           
        if( $request->hasFile("xml") )
        {      
            $xmlData    = (new AprobacionData($request->file("xml")));            
            $xml        = $request->file("xml");
            $fileName   = $xmlData->get("RNCComprador").$xmlData->get("eNCF").".xml";

            $ent        = (new \DGII\Model\Hacienda)->where("rnc", $ent)->first() ?? abort(404);
            $entData    = $xmlData->all();
            
            if( !app("files")->exists(($path = __path("{AprobacionComercial}"))) )
            {
                app("files")->makeDirectory($path, 0775, true);
            } 
            
            $data["Estado"]                         = 1;
            
            $ruls["Version"] 						= "required";
            $ruls["RNCEmisor"] 						= ["required", new \DGII\Rules\RNC];
            $ruls["eNCF"] 							= ["required",new \DGII\Rules\UniqueENCF($entData), new \DGII\Rules\Encf];
            $ruls["FechaEmision"] 					= "required";
            $ruls["MontoTotal"] 					= "required|numeric";
            $ruls["RNCComprador"] 					= "required";
            $ruls["Estado"] 						= ["required",Rule::in([1,2])];
            $ruls["DetalleMotivoRechazo"] 			= "";			
            $ruls["FechaHoraAprobacionComercial"] 	= "";

            $messages["unique"] = __("validate.unique");
            $attrs["eNCF"] = "comprobante"; 

            $validate = validator($entData, $ruls, $messages, $attrs);
            
            if( ($errors = $validate->errors())->any() )
            {
                return response("Insatisfactorio", 400);
            }                     
           
            if( $xml->move($path, $fileName) ) 
            {
                $storData               = $xmlData->all();
                $storData["filename"]   = $fileName;
                $storData["path"]       = "$path/$fileName";
                $storData["state"]      = $xmlData->get("Estado");

                if( $ent->saveAprobacionComercial($storData) )
                {
                    return response("Satisfactorio", 200);
                }                
            }           
        }

        return response("Insatisfactorio", 400);        
    }
}