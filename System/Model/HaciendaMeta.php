<?php
namespace DGII\Model;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

use Illuminate\Database\Eloquent\Model;

class HaciendaMeta extends Model 
{
    protected $table = 'HACIENDAS_META';

    protected $fillable = [
        "id",
        "hacienda_id",
        "type",
        "key",
        "value",
        "created_at",
        "upated_at"
    ];
}