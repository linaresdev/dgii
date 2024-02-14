<?php
namespace DGII\Http\Support;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use DGII\Facade\ECF;

class EnviarAprobacionComercial
{
    public function xmlMessage($messages)
    {
        $stub = '<?xml version="1.0" encoding="UTF-8"?>
        <EnvioAprobacionComercialModel>
            <Mensajes>{Mensajes}</Mensajes>
        </EnvioAprobacionComercialModel>';

        $stub = str_replace('{Mensajes}', implode(',', $messages), $stub);

        $dom = new \DOMDocument;

        $dom->preserveWhiteSpace    = false;
        $dom->formatOutput          = true;

        $dom->loadXML($stub);

        return $dom->saveXML();
    }

    public function enviarAprobacionComercial( $ent, $request ) 
    {
        $ruls["urlAprobacionComercial"]     = "required";
        $ruls["urlAutenticacion"]           = "";
        $ruls["rnc"]                        = "required";
        $ruls["encf"]                       = "required";
        $ruls["estadoAprobacion"]           = "required";
        
        $V = validator($request->all(), $ruls);

        if( !$V->errors()->any() )
        {
            if( ($ecf = $ent->getEcf($request->rnc, $request->encf)) != null )
            {
                $xmlEcf = app("files")->get($ecf->path);

                if( ($ECF = ECF::load($xmlEcf))->hasData() )
                {
                    dd($ECF->makeAprobacionComercial());
                }
            }

            return response($this->xmlMessage(["El documento solicitado no fue encontrado"]), 400, [
                "Content-Type" => "text/xml;charset=utf-8"
            ]);
        }

        return response($this->xmlMessage(
            ['No existe un documento para procesar']), 400, ["Content-Type" => "text/xml;charset=utf-8"]
        );

        return $this->xmlMessage(['Recivido']);
    }
}