<?php
namespace DGII\Http\Support;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use Illuminate\Validation\Rule;

class RecepcionECF 
{

    protected $data;

    protected $errors;

    public function xmlNews($messages=[])
    {
        $stub   = app("files")->get(__path('{xmlstub}/messages.txt'));
        $msg    = null;
        $tab = str_repeat(" ", 4);
        
        if(is_array($messages) )
        {
            foreach($messages as $mesage)
            {
                $msg .= $tab.$mesage."\n";
            }
        }

        return str_replace('{Mensaje}', "\n".$msg, $stub);
    }

    public function checkXml($xml, $xsd)
    {
        $elements = (new \SimpleXMLElement( $xml ));
        $header = (array) $elements->Encabezado;
        $data["Version"]  = $header["Version"];
        
        $IdDoc      = (array) $elements->Encabezado->IdDoc;
        $Emisor     = (array) $elements->Encabezado->Emisor;
        $Comprador  = (array) $elements->Encabezado->Comprador;
        $Totales    = (array) $elements->Encabezado->Totales;

        ## Collect
        $data = array_merge($data, $IdDoc);
        $data = array_merge($data, $Emisor);
        $data = array_merge($data, $Comprador);
        $data = array_merge($data, $Totales);  

        $this->data = $data;
        
        ## RULS
        $rols["Version"]        = "required|numeric";
        $rols["TipoeCF"]        = ["required","numeric",Rule::in([31,33,34,44])];
        $rols["eNCF"]           = "required|isEncf";
        $rols["RNCEmisor"]      = "required|numeric|isRnc";
        $rols["FechaEmision"]   = "required";
        $rols["RNCComprador"]   = "required|numeric|isRnc";
        $rols["MontoTotal"]     = "required|numeric";

        ## VALIDATORS
        return  validator($data, $rols);
    }

    public function recepcionECF($request)
    {
        if( $request->user()->can("isexpire", $request) )
        {
            if( $request->hasFile("xml") )
            {
                $xmlData    = ($file = $request->file("xml"))->getContent();
                $fileName   = $file->getClientOriginalName();
                $xsd        = __path('{wvalidate}/RecepcionComercial.xsd');
               
                if( ($errors = $this->checkXml($xmlData, $xsd)->errors())->any() )
                {   
                    return response($this->xmlNews($errors->all()), 400, [
                        'Content-Type' => 'application/xml'
                    ]);
                }

                if( !app("files")->exists(($path = __path("{Recepcion}"))) )
                {
                    app("files")->makeDirectory($path, 0775, true);
                } 

                if( app("files")->exists($path."/".$fileName) )
                {
                    return response($this->xmlNews(["El documento existe"]), 400, [
                        'Content-Type' => 'application/xml'
                    ]);
                }

                if( $file->move($path, $fileName) ) 
                {
                    return response($this->xmlNews(["Recibido"]), 200, [
                        'Content-Type' => 'application/xml'
                    ]);
                }                

                return response($this->xmlNews(["No fue posible procesar el documento"]), 400, [
                    'Content-Type' => 'application/xml'
                ]);
            }
        }

        $errors = $this->xmlNews([
            "Autenticacion requerida"
        ]);
        return response($errors, 400, [
            'Content-Type' => 'application/xml'
        ]);
    }
}