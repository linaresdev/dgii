<?php
namespace DGII\Model;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ARECF extends Model {

    protected $table = 'ARECF';

    protected $fillable = [
        "RNCEmisor",
        "RNCComprador",
        "eNCF",
        "Estado",
        "FechaHoraAcuseRecibo",
        "CodigoMotivoNoRecibido",
        "pathECF",
        "pathARECF",
        "created_at",
        "updated_at"
    ];

    public function acecf()
    {
        return $this->hasOne(ACECF::class, "eNCF", "eNCF");
    }

    public function getOriginalEcf()
    {
        return $this->attributes["pathECF"];
    }

    public function pathECF(): Attribute {        
        return Attribute::make(
            get: fn ($value) => (new \DGII\Support\ECF)->path($value)
        );
    }

    public function arecf()
    {
        return new \DGII\Support\ARECF($this->pathARECF);        
    }

    public function item( $key )
    {
        return $this->pathECF->get($key);
    }

    public function razonSocialEmisor()
    {
        return $this->pathECF->get("RazonSocialEmisor");
    }
    public function razonSocialComprador()
    {
        return $this->pathECF->get("RazonSocialComprador");
    }

    public function description()
    {
        return $this->pathECF->getDescription();
    }
    public function fechaEmision()
    {
        return $this->pathECF->get("FechaEmision");
    }
    
    public function montoTotal()
    {
        return $this->pathECF->get("MontoTotal");
    }
}