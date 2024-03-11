<?php
namespace DGII\Support;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

class ACECF
{

    protected $format;

    protected $original=[];

    protected $signer;

    public function load($xml)
    {
        if( app('files')->exists($xml) )
        {
            $xml = app("files")->get($xml);
            $xml = (array) (new \SimpleXMLElement( $xml ));
           
            if( array_key_exists('DetalleAprobacionComercial', $xml) )
            {
                $this->original = (array) $xml['DetalleAprobacionComercial'];

                foreach($this->original as $label => $key )
                {
                    if( method_exists($this, $label) )
                    {
                        $this->format[$label] = $this->{$label}($key);
                    }
                    else {
                        $this->format[$label] = $key;
                    }
                }
            }
    
            if( array_key_exists("Signature", $xml) )
            {
                $this->signer = (array) $xml["Signature"];
            }
        }
        
        return $this;
    }

    /*
    * FORMAT */
    protected function MontoTotal($value)
    {
        return "RD$ ".\Number::format($value);
    }

    protected function Estado($value)
    {
        if( $value == 1) return __("words.approved");
        if( $value == 2) return __("words.rejected");
    }

    /*
    * OUT DATA */
    public function tableFormat($space)
    {
        $data=null;
        foreach($this->format as $label => $value)
        {
            $data .= "$label ".str_repeat('-', ($space - strlen($label)))."$value\n";
        }
        return $data;
    }
    public function arrayFormat()
    {
        return $this->format;
    }
    public function toArray()
    {
        return $this->original;
    }

    public function toJSON()
    {
        return json_encode($this->original);
    }
}