<?php
namespace DGII\User\Model;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use DGII\Support\Guard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class UserStack extends Model 
{
    protected $table = 'userstask';

    protected $fillable = [
        "id",
        "user_id",
        "type",
        "host",
        "guard",
        "header",
        "token",
        "path",
        "agent",
        "meta",
        "activated",
        "created_at",
        "updated_at"
    ];

    public function meta(): Attribute {
        return Attribute::make(
            get: fn ($value) => json_decode($value),
            set: fn ($value) => json_encode($value)
        );
    }

    public function add( $type=null, $header=null, $message=[])
    {
        return $this->create([
            "type"      => $type,
            "host"      => request()->ip(),
            "header"    => $header,
            "path"      => request()->path(),
            "agent"     => request()->userAgent(),
            "meta"      => $this->currentMeta($message)
        ]);
    }

    public function currentMeta($data=null)
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