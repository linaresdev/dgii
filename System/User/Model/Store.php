<?php
namespace DGII\User\Model;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/
use DGII\Model\Term;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Store extends Authenticatable {

    protected $table = 'users';

    protected $fillable = [
        "type",
        "name",
        "fullname",
        "firstname",
        "lastname",
        "rnc",
        "user",
        "cellphone",
        "email",
        "email_verified_at",
        "password",
        "pystring",
        "birthday",
        "gender",
        "avatar",
        "activated",
        "created_at",
        "updated_at"
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
  
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dispatchesEvents = [
    ];

    /*
    * SETTINGS */
    public function setPasswordAttribute($value) {
        $value = trim($value);
        $this->attributes['password']    = bcrypt($value);
    }

    /*
    * RELATIONS */
    public function meta() {
        return $this->hasMany(UserMeta::class, "user_id");
    }
    public function groups() {
        return $this->belongsToMany(Term::class, "termstaxonomies", "tax_id", "term_id")->withPivot(
           "meta"
        )->using(\DGII\User\Model\UserGroupPivot::class);
    }   

    /*
    * SYNCS */
    public function syncGroup($gID=0, $rols=null) {
        if( is_numeric($gID) ) {
            if($this->groups()->attach($gID, ["meta" => $rols])) {

            }
        }
        elseif( is_string($gID) && !empty( ($group = $this->group($gID)) ) ) {            
            $this->groups()->attach($group->id, ["meta" => $rols]);
        }        
    }

    /*
    * QUERY */
    public function getFromUser($user) {
        return $this->where("user", $user)->first();
    }
    public function getFromMail($email) {
        return $this->where("email", $email)->first();
    }
    
    public function group( $slug=null ) {
        return (new Term)->tax("user-group", $slug);        
    }

    public function rol($slug) {
        return $this->groups->where("slug", $slug)->first();
    }

    /*
    * HAS && IS */
    public function hasGroup($slug) {
        return ( $this->group($slug) != null );
    }

    /*
	* GUARD */
	public function currentDevice() {
		return xmalla("guard")->device(request()->userAgent());
	}
	public function currentPlatform() {
		return xmalla("guard")->getPlatform(request()->userAgent());
	}
	public function currentBrowser() {
		return xmalla("guard")->getBrowser(request()->userAgent());
	}
	public function currentRobot() {
		return xmalla("guard")->getRobot(request()->userAgent());
	}
}