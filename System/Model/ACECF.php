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
    public function pathAcecf()
    {
        return $this->attributes["acecf"];
    }

    public function ecf(): Attribute {        
        return Attribute::make(
            get: fn ($value) => (new \DGII\Support\ECF)->path($value)           
        );
    }

    public function acecf(): Attribute {        
        return Attribute::make(
            get: fn ($value) => (new \DGII\Support\ACECF)->load($value)           
        );
    }

    public function info()
    {
        return $this->acecf->arrayFormat();
    }

    public function item( $key )
    {
        return $this->pathECF->get($key);
    }

    public function razonSocialEmisor()
    {
        return $this->ecf->get("RazonSocialEmisor");
    }
    public function razonSocialCompador()
    { dd($this);
        return $this->ecf->get("RazonSocialComprador");
    }
    
    public function montoTotal()
    {
        return $this->pathECF->get("MontoTotal");
    }
}