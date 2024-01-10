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
        "name",
        "serial",
        "slug",
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

    ## SETTINGS
    public function setPasswordAttribute($value) {
		$this->attributes['password'] = Crypt::encryptString($value);
	}

    ## VALIDATIONS
    public function has($slug) {
        return ($this->where("slug", $slug)->count() == 0);
    }

    ## RELATIONS
    public function user() {
        return $this->hasOne(\DGII\User\Model\Store::class, "user", "slug");
    }

    public function users() {
        return $this->belongsToMany(Term::class, "termstaxonomies", "term_id", "tax_id");
    }

    // public function groups() {
    //    return $this->belongsToMany(Term::class, "termstaxonomies", "term_id", "tax_id");
    // }

    ## QUERY
    public function group($type, $slug) {
        return (new Term)->where("type", $type)->where("slug", $slug)->first() ?? null;
    }
}