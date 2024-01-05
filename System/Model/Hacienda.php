<?php
namespace DGII\Model;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Hacienda extends Model
{

    protected $table = 'HACIENDAS';

    protected $fillable = [
        "id",
        "name",
        "slug",
        "token",
        "password",
        "certify",
        "counter_emisioncomprobante",
        "counter_emisionaprobacioncomercial",
        "counter_recepcionaprobacioncomercial",
        "counter_recepcionacuserecibo",
        "xml",
        "meta",
        "activated",
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

    // protected $timestamps = false;

    // protected $dateFormat = 'U'

}