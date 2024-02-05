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

    public function recepcionComprobante($request)
    { 
        
        if( $request->user()->can("isexpire", $request) )
        {            
            if( $request->hasFile("xml") )
            {      
                $xmlData = (new AprobacionData($request->file("xml")));     
                $entity = $xmlData->entity();

                if( !$xmlData->hasEntity() )
                {
                    return response(json_encode(["Entidad no valida"]), 400, [
                        'Content-Type' => 'application/json'
                    ]);
                }

                $data["Estado"]                         = 1;
                $ruls["Version"] 						= "required";
                $ruls["RNCEmisor"] 						= "required|isRnc";
                $ruls["eNCF"] 							= "required|isEncf|unique:\DGII\Model\AprobacionComercial,eNCF";
                $ruls["FechaEmision"] 					= "required";
                $ruls["MontoTotal"] 					= "required|numeric";
                $ruls["RNCComprador"] 					= "required";
                $ruls["Estado"] 						= ["required",Rule::in([1,2])];
                $ruls["DetalleMotivoRechazo"] 			= "";			
                $ruls["FechaHoraAprobacionComercial"] 	= "";

                $messages["unique"] = __("validate.unique");
                $attrs["eNCF"] = "Nombre o Numero de comprobante";
            
                $validate = validator($xmlData->all(), $ruls, $messages, $attrs);

                if( ($errors = $validate->errors())->any() )
                {
                    $message["estado"] 		= "Error de validación";
                    $message["messages"] 	= $errors->all();
                    
                    return response(json_encode($message), 400, [
                        'Content-Type' => 'application/json'
                    ]);
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
                        return response(json_encode("Aprobacion recibida"), 200, [
                            'Content-Type' => 'application/json'
                        ]);
                    }
                    else 
                    {
                        return response(json_encode("Error al tratar de registrar los datos"), 400, [
                            'Content-Type' => 'application/json'
                        ]);
                    }                
                }

            }
            else {
                return response(json_encode(["Insatisfactorio"]), 400, [
                    'Content-Type' => 'application/json'
                ]);
            }

            return "Recepcion";
        }

        return response()->json("Autenticacion requerida.", 401);        
        
    }
}