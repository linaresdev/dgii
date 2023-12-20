<?php
namespace DGII\User\Model;

/*
 *---------------------------------------------------------
 * ©Delta
 * Santo Domingo República Dominicana.
 *---------------------------------------------------------
*/

use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model {

   protected $table = "usersmeta";

   protected $fillable = [
      "id",
      "user_id",
      "type",
      "key",
      "value",
      "activated",
      "created_at",
      "updated_at"
   ];

   //protected $timestamps = false;
}