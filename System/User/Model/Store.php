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
use Laravel\Sanctum\NewAccessToken;
use Illuminate\Support\Facades\Crypt;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Store extends Authenticatable {

    use HasApiTokens, HasFactory, Notifiable;
    
    protected $table = 'users';

    protected $customToken;

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
        "pem",
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
    * CUSTOM SANCTUM */
    public function loadCustomToken($token)
    {
        $this->customToken = $token;
    }
    public function createToken(string $name, array $abilities = ['*'], \DateTimeInterface $expiresAt = null)
    {
        $plainTextToken = sprintf(
            '%s%s%s',
            config('sanctum.token_prefix', ''),
            $tokenEntropy = \Str::random(40),
            hash('crc32b', $tokenEntropy)
        );

        if( $this->customToken != null ) 
        {
            $plainTextToken = $this->customToken; 
        }

        $token = $this->tokens()->create([
            'name' => $name,
            'token' => hash('sha256', $plainTextToken),
            'abilities' => $abilities,
            'expires_at' => $expiresAt,
        ]);

        return new NewAccessToken($token, $token->getKey().'|'.$plainTextToken);
    }

    // public function redirectTo(Request $request)
    // {
    //     return redirect(https)
    // }

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

    public function entities()
    {
        return $this->groups->where("type", "entity-group");
    }
    
    public function stack() {
        return $this->hasMany(UserStack::class, "user_id");
    }

    public function onPem($x509)
    {
        return $this->where("pem", $x509)->first() ?? null;
    }

    public function personalToken($token) {
        return (new PersonalAccessToken)->where("token", $token)->first() ?? null;
    }

    /*
    * SYNCS */
    public function syncGroup($gID=0, $rols=null)
    {
        if( is_numeric($gID) ) 
        {
            $this->groups()->attach($gID, ["meta" => $rols]);
        }
        elseif( is_string($gID) ) 
        {  
            if( ($group = (new Term)->getUserGroup($gID)) != null )
            {
                $this->groups()->attach($group->id, ["meta" => $rols]);
            }
        }
        elseif( is_object($gID) )
        {
            $this->groups()->attach($gID->id, ["meta" => $rols]);
        }        
    }

    public function isGroup($slug)
    {
        return ($this->groups->where("slug", $slug)->count() > 0);
    }

    public function isTypeGroup($type) {
        return ($this->groups->where("type", $type)->count() > 0);
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
    public function gID($slug)
    {

    }
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

        return (object) [
            "view"      => 0,
            "insert"    => 0,
            "update"    => 0,
            "delete"    => 0
        ];
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