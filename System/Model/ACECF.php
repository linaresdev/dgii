<?php
namespace DGII\Model;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ACECF extends Model {

    protected $table = 'ACECF';

    protected $fillable = [
        "RNCEmisor",
        "RNCComprador",
        "eNCF",
        "Estado",
        "DetalleMotivoRechazo",
        "FechaHoraAprobacionComercial",
        "ecf",
        "acecf",
        "created_at",
        "updated_at"
    ];

    public function getOriginalEcf()
    {
        return $this->attributes["ecf"];
    }

    public function ecf(): Attribute {        
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