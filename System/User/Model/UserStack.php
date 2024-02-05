<?php
namespace DGII\User\Model;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

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
}