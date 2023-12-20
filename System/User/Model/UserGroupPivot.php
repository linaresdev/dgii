<?php
namespace DGII\User\Model;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Casts\Attribute;

class UserGroupPivot extends Pivot
{
    public function meta(): Attribute
    {        
        return Attribute::make(
            set: fn ($value) => json_encode($value),
            get: fn ($value) => new UserRol($value, $this->attributes["term_id"])
        );
    }
}