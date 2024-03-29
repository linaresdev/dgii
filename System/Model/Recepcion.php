<?php
namespace DGII\Model;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

use Illuminate\Database\Eloquent\Model;

class Recepcion extends Model {

    protected $table = 'RECEPCION';

    protected $fillable = [
        "id",
        "hacienda_id",
        "eNCF",
        "FechaEmision",
        "RNCEmisor",
        "RNCComprador",
        "RazonSocialComprador",
        "TipoeCF",
        "fileName",
        "path",
        "state",
        "created_at",
        "updated_at"
    ];
}