<?php
namespace DGII\Http\Support\Recepcion;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

class AprobacionData {

    protected $stors = [];

    protected $fillable = [
        "Version",
        "RNCEmisor",
        "eNCF",
        "FechaEmision",
        "MontoTotal",
        "RNCComprador",
        "Estado",
        "DetalleMotivoRechazo",
        "FechaHoraAprobacionComercial"
    ];

    public function __construct($xml)
    {
        $data = new \SimpleXMLElement($xml->getContent());
       
        if( isset($data->DetalleAprobacionComercial) )
        {
            $data = (array) $data->DetalleAprobacionComercial;

            foreach( $this->fillable as $field )
            {
                if( array_key_exists($field, $data) )
                {
                    $this->stors[$field] = $data[$field];
                }
            }

            if( array_key_exists("RNCComprador", $data) )
            {
                $this->entity = $this->getEntity($data["RNCComprador"]);
            }
        }
        
    }

    public function all()
    {
        return $this->stors;
    }

    public function get($key)
    {
        if( array_key_exists($key, $this->stors) )
        {
            return $this->stors[$key];
        }
    }

    public function hasEntity()
    {
        return ( !empty($this->entity) );
    }
    public function getEntity($rnc)
    {
        return (new \DGII\Model\Hacienda)->getEntity($rnc);
    }
    public function entity()
    {
        return $this->entity;
    }
}