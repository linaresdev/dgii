<?php
namespace DGII\Support;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

class ARECF
{
    protected $data=[];

    protected $format=[];

    public function __construct($file)
    {
        if( app("files")->exists($file) )
        {
            $fileData = (array) (new \SimpleXMLElement( 
                app("files")->get($file) 
            ));
            
            if( array_key_exists("DetalleAcusedeRecibo", $fileData) )
            {
                $this->data = (array) $fileData["DetalleAcusedeRecibo"];

                foreach($this->data as $label => $value )
                {
                    if( method_exists($this, $label) )
                    {
                        $this->format[$label] = $this->{$label}($value);
                    }
                    else {
                        $this->format[$label] = $value;
                    }
                }
            }
        }
    }

    public function get($key)
    {
        if( array_key_exists($key, $this->data) )
        {
            return $this->data[$key];
        }
    }

    public function arrayFormat()
    {
        return $this->format;
    }

    public function getData()
    {
        return $this->data;
    }
}