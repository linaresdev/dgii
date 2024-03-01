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

    public function getOriginalEcf()
    {
        return $this->attributes["pathECF"];
    }

    public function pathECF(): Attribute {        
        return Attribute::make(
            get: fn ($value) => (new \DGII\Support\ECF)->path($value)
        );
    }

    public function item( $key )
    {
        return $this->pathECF->get($key);
    }

    public function razonSocialEmisor()
    {
        return $this->pathECF->get("RazonSocialEmisor");
    }
    
    public function montoTotal()
    {
        return $this->pathECF->get("MontoTotal");
    }
}