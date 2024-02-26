<?php
namespace DGII\Http\Support;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use DGII\Model\Hacienda;

class ConsultaRecibo 
{
    public function consultaRecibo($entity, $request)
    {
        $stub = app("files")->get(__path('{xmlstub}/Consulta.txt'));

        ## Parámetros de entrada válidos
        ## Parámetros de entrada requeridos hayan sido completados.
        if( $this->checkInput($request->all())->errors()->any() )
        {
            $rems[] = "<rnc>{rnc}</rnc>\n";
            $rems[] = "<encf>{encf}</encf>\n";
            $rems[] = "<estado>{estado}</estado>\n";

            foreach( $rems as $rem )
            {
                $stub = str_replace($rem, null, $stub);
            }

            $stub = str_replace('{mensajes}', "Parámetros de entrada no válidos", $stub);  

            return response($this->format($stub), 400, [
                'Content-Type' => 'application/xml'
            ]);
        }         

        ## RNC del token no autorizado.
        if( ($query = $entity->getARECF($request)) == null )
        {            
            $data["rnc"]        = $request->get("Rnc");
            $data["encf"]       = $request->get("Encf");
            $data["estado"]     = 0;   
            $data["mensajes"]   = "RNC no autorizado para esta consulta";

            foreach( $data as $key => $value )
            {            
                $stub = str_replace('{'.$key.'}', $value, $stub);
            }

            return response($this->format($stub), 400, [
                'Content-Type' => 'application/xml'
            ]);
        }
        else
        {            
            $stub = str_replace("<mensajes>{mensajes}</mensajes>\n", null, $stub);
            //dd($stub);
            $data["rnc"]        = $request->get("Rnc");
            $data["encf"]       = $request->get("Encf");
            $data["estado"]     = $query->Estado;        

            foreach( $data as $key => $value )
            {            
                $stub = str_replace('{'.$key.'}', $value, $stub);
            }
        }        
        
        return response($this->format($stub), 200, [
            'Content-Type' => 'application/xml'
        ]);
    }

    public function checkInput($data)
    {
        $ruls["Rnc"]    = ["required", new \DGII\Rules\RNC];
        $ruls["Encf"]   = ["required", new \DGII\Rules\Encf];

        return validator($data, $ruls);
    }

    public function format( $stub )
    {
        $dom = new \DOMDocument;

        $dom->preserveWhiteSpace    = false;
        $dom->formatOutput          = true;

        $dom->loadXML($stub);

        return $dom->saveXML();
    }
}