<?php
namespace DGII\Model;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

use DGII\Model\Term;
use DGII\User\Model\Store;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Hacienda extends Model
{

    protected $table = 'HACIENDAS';

    protected $fillable = [
        "id",
        "env",
        "name",
        "rnc",
        "serial",
        "p12",
        "password",
        "xml",
        "meta",
        "activated",
        "emision_comprobante",
        "emision_aprobacion",
        "recepcion_aprobacion",
        "recepcion_acuserecibo",
        "created_at",
        "updated_at"
    ];

    public function makeUniqueSlug() {
        $this->update(["slug" => $this->id.str_replace('-', null, $this->slug)]);
    }

    ## SETTINGS
    public function p12(): Attribute {        
        return Attribute::make(
            set: fn ($value) => Crypt::encryptString($value),
            get: fn ($value) => Crypt::decryptString($value)
        );
    }
    
    public function password(): Attribute {        
        return Attribute::make(
            set: fn ($value) => Crypt::encryptString($value),
            get: fn ($value) => Crypt::decryptString($value)
        );
    }
    public function meta(): Attribute {        
        return Attribute::make(
            set: fn ($value) => json_encode($value),
            get: fn ($value) => json_decode($value)
        );
    }

    ## VALIDATIONS
    public function has($slug) {
        return ($this->where("slug", $slug)->count() == 0);
    }

    ## RELATIONS
    public function metaData()
    {
        return $this->hasMany(HaciendaMeta::class, "hacienda_id");
    }

    public function user() {
        return $this->hasOne(\DGII\User\Model\Store::class, "rnc", "rnc");
    }

    public function users() {
        return $this->group->users();
    }

    public function AprobacionComercial()
    {
        return $this->hasMany(\DGII\Model\AprobacionComercial::class, "hacienda_id");
    }
    public function Recepcion()
    {
        return $this->hasMany(\DGII\Model\Recepcion::class, "hacienda_id");
    }
    public function arecf()
    {
        return $this->hasMany(\DGII\Model\ARECF::class, "hacienda_id");
    }
    
    public function acecf()
    {
        return $this->hasMany(\DGII\Model\ACECF::class, "hacienda_id");
    }

    public function saveAprobacionComercial($data) {
        return $this->AprobacionComercial()->create($data);
    }

    public function saveRecepcion($data) {
        return $this->Recepcion()->create($data);
    }
    public function saveARECF($data) {
        return $this->arecf()->create($data);
    }
    public function saveACECF($data) {
        return $this->acecf()->create($data);
    }

    ## add
    public function addConfig( $data=[] )
    {
        if( !empty($data) && is_array($data) )
        {
            foreach($data as $key => $value )
            {
                $this->metaData()->create([
                    "type"  => "config",
                    "key"   => $key,
                    "value" => $value
                ]);
            }

            return true;
        }

        return false;
    }

    ## UPDATE
    public function updateConfig( $key=null, $value=null )
    {
        $data = $this->metaData()->where("type", "config")->where("key", $key);
        
        if( $data->count() > 0 )
        {
            $config = $data->first();

            $config->value = $value;

            return $config()->save();
        }

        return false;
    }

    public function toggleConfig($key, $value)
    {
        if( ($data = $this->metaData()->where("type", "config")->where("key", $key))->count() > 0 )
        {
            $config         = $data->first();
            $config->value  = $value;
            
            return $config->save();
        }
        else {
            return $this->addConfig([$key => $value]);
        }
    }

    ## QUERY

    public function getConfig()
    {
        $arreglo = [];

        if( ($data = $this->metaData()->where("type", "config"))->count() > 0  ) 
        {
            $arreglo = null;

            foreach($data->select("key", "value")->get() as $row ) 
            {
                $arreglo[$row->key] = $row->value;
            }
        }  
        
        return $arreglo;
    }

    public function getEntity($rnc)
    {
        return $this->where("rnc", $rnc)->first() ?? null;
    }
    public function group() {
        return $this->hasOne(Term::class, "slug", "rnc");
    }

    public function getTermID() {
        if( ($term = (new Term)->where( "slug", $this->rnc )->first()) ?? NULL ) {
            return $term->id;
        }
    }

    public function getEcf($rnc, $encf)
    {
        return $this->Recepcion->where("RNCComprador", $rnc)->where("eNCF", $encf)->first() ?? null;
    }
    public function getARECF($request)
    {
        return  $this->arecf()->where("RNCComprador", $request->get("Rnc"))
                    ->where("eNCF", $request->get("Encf"))
                    ->first() ?? null;
    }
}