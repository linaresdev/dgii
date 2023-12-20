<?php
namespace DGII\Http\Support;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use Illuminate\Validation\Rule;

class RecepcionComprobante {

    public function recepcionComprobante($request) {
        
        if( $request->hasFile("xml") ) {

            $data = $request->file("xml");
			$data = new \SimpleXMLElement($data->getContent());
			$data = (array) $data->DetalleAprobacionComercial;

            $ruls["Version"] 						= "required";
			$ruls["RNCEmisor"] 						= "required|isRnc";
			$ruls["eNCF"] 							= "required|isEncf";
			$ruls["FechaEmision"] 					= "required";
			$ruls["MontoTotal"] 					= "required|numeric";
			$ruls["RNCComprador"] 					= "required";
			$ruls["Estado"] 						= ["required",Rule::in([1,2])];
			$ruls["DetalleMotivoRechazo"] 			= "required";			
			$ruls["FechaHoraAprobacionComercial"] 	= "required";

            $validate = validator($data, $ruls);

            if( ($errors = $validate->errors())->any() )
            {
                $message["estado"] 		= "Error de validación";
				$message["messages"] 	= $errors->all();

				return response(json_encode($message), 400, [
					'Content-Type' => 'application/json'
                ]);
            }

        }
        else {
            return response(json_encode(["Insatisfactorio"]), 400, [
				'Content-Type' => 'application/json'
			]);
        }

        return "Recepcion";
    }
}