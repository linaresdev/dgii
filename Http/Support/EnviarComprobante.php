<?php
namespace DGII\Http\Support;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

class EnviarComprobante 
{
    public function enviarComprobante($request) {
        
        $ruls["rnc"]                = "required";
        $ruls["tipoEncf"]           = "required";
        $ruls["urlRecepcion"]       = "required";
        
        //$ruls["urlAutenticcion"]    = "required";

        $checkData = validator($request->all(), $ruls);

        if( $checkData->errors()->any() )
        {
            return response()->json([
                "Error Validation",
                "messages" => $checkData->errors()->all()
            ]);
        }

        dd($request->header("Content-Type"));
    }
}