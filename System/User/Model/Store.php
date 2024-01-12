<?php
namespace DGII\User\Model;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/
use DGII\Model\Term;
use DGII\Support\Guard;
use DGII\Model\TermTaxonomy;
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

    public function entities(){}
    public function entity($slug){}
    
    public function stack() {
        return $this->hasMany(UserStack::class, "user_id");
    }

    /*
    * SYNCS */
    public function syncGroup($gID=0, $rols=null) {
        if( is_numeric($gID) ) 
        {
            $this->groups()->attach($gID, ["meta" => $rols]);
        }
        elseif( is_string($gID) ) 
        {            
            if( !empty( ($group = $this->group($gID)) ) ) 
            {
                $this->groups()->attach($group->id, ["meta" => $rols]);
            }
        }
        elseif( is_object($gID) )
        {
            $this->groups()->attach($gID->id, ["meta" => $rols]);
        }        
    }

    /*
    * USERS TAXONOMIES */
    public function tax()
    {
        return $this->belongsToMany(Term::class, "termstaxonomies", "tax_id", "term_id")->withPivot(
            "meta"
         )->using(\DGII\User\Model\UserGroupPivot::class);
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
        return $this->tax->where("slug", $slug)->first() ?? null;        
    }

    public function rol($slug) 
    {
        $tax     = $this->tax->where("type", "user-group");
        $group   = $tax->where("slug", $slug);        
 
        if($group->count() > 0 ) {
            return $group->first()->pivot->meta;
        }
    }

    /*
    * HAS && IS */
    public function hasGroup($slug) {
        return ( $this->group($slug) != null );
    }

    /*
    * NEWS */
    public function news($type, $header, $message=null)
    {
        return $this->stack()->create([
            "type"      => $type,
            "host"      => request()->ip(),
            "header"    => $header,
            "path"      => request()->path(),
            "agent"     => request()->userAgent(),
            "meta"      => $this->footerGuard($message)
        ]);
    }

    /*
	* GUARD */
    public function footerGuard($data=null)
    {
        $data["ip"]        = request()->ip();
        $data["device"]    = $this->currentDevice();
        $data["platform"]  = $this->currentPlatform();
        $data["browser"]   = $this->currentBrowser();
        $data["robot"]     = $this->currentRobot();            
    
        return $data;
    }
	public function currentDevice() {
		return (new Guard)->device(request()->userAgent());
	}
	public function currentPlatform() {
		return (new Guard)->getPlatform(request()->userAgent());
	}
	public function currentBrowser() {
		return (new Guard)->getBrowser(request()->userAgent());
	}
	public function currentRobot() {
		return (new Guard)->getRobot(request()->userAgent());
	}
}